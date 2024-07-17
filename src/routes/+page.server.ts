import { fail, redirect } from "@sveltejs/kit";
import type { Actions, PageServerLoad } from "./$types";
import type { Provider } from "@supabase/supabase-js";
import { PUBLIC_OSU_SERVER_ENDPOINT } from "$env/static/public";

export const load: PageServerLoad = async ({ locals }) => {
  const matches = await locals.supabase
    .from("matches")
    .select(
      `*, rounds (name, events (id, name, event_groups(*)) ), match_participants (participants (teams (name))), spectators(count), match_maps(*, scores(*))`
    )
    .eq("ongoing", true)
    .is("spectators.stopped_at", null);

  const events = await locals.supabase
    .from("events")
    .select(
      `*, participants(teams(team_members( user_profiles(*)))), organisations(name), event_groups(*), event_options(*)`
    )
    .neq("event_status_id", 1)
    .order("created_at", { ascending: false })
    .limit(10);

  const session = await locals.getSession();
  if (session) {
    events.data.forEach((event) => {
      event.participants.forEach((participant) => {
        participant.teams.team_members.forEach((teamMember) => {
          if (teamMember.user_profiles.user_id === session.user.id) {
            event.disabled = true;
            event.disabledMessage = "You are already registered";
          }
        });
      });
    });
  } else {
    events.data.forEach((event) => {
      event.disabled = true;
      event.disabledMessage = "You need to be logged in to register for events";
    });
  }

  return {
    matches: matches.data,
    events: events.data,
  };
};

export const actions = {
  dismissNotification: async ({ locals, request }) => {
    const formData = await request.formData();

    const notificationId = formData.get("notification-id");

    const updated = await locals.supabase
      .from("notifications")
      .update({ dismissed_at: new Date() })
      .eq("id", notificationId)
      .select("*")
      .single();

    if (updated.data.href) {
      throw redirect(302, updated.data.href);
    }
  },
  makeQuickMatch: async ({ locals, request }) => {
    const formData = await request.formData();

    const senderId = formData.get("sender-id");
    const userId = formData.get("opponent-id");
    const mapPoolId = formData.get("map-pool-id");
    const bestOf = formData.get("best-of");

    const user = await locals.supabase
      .from("user_profiles")
      .select("id, name, team_members(teams!inner(id))")
      .eq("user_id", senderId)
      .eq("team_members.teams.is_personal_team", true)
      .single();

    console.log(user);

    const notification = await locals.supabase
      .from("notifications")
      .insert({
        user_id: userId,
        title: "Match Invite",
        body: `You have been invited to a match against ${user.data.name}!`,
        type: "match_invite",
      })
      .select("id")
      .single();

    console.log(notification);

    const invite = await locals.supabase.from("match_invites").insert({
      //@ts-ignore
      sender_id: user.data.team_members[0].teams.id,
      pool_id: mapPoolId,
      best_of: bestOf,
      notification_id: notification.data.id,
    });
  },
  acceptMatchInvite: async ({ locals, request }) => {
    const formData = await request.formData();

    const matchInviteId = formData.get("match-invite-id");

    const insertData = async (table, data) => {
      const result = await locals.supabase.from(table).insert(data).select("*");

      if (result.error) throw new Error(result.error.message);
      return result.data;
    };

    const matchInvite = await locals.supabase
      .from("match_invites")
      .select(
        "*, teams!inner(name, team_members(user_profiles(id))), notifications(user_id)"
      )
      .eq("id", matchInviteId)
      .eq("teams.is_personal_team", true)
      .single();

    await locals.supabase
      .from("notifications")
      .update({ dismissed_at: new Date() })
      .eq("id", matchInvite.data.notification_id);

    const userPersonalTeam = await locals.supabase
      .from("teams")
      .select("*, team_members!inner(*, user_profiles!inner(*))")
      .eq("is_personal_team", true)
      .eq(
        "team_members.user_profiles.id",
        matchInvite.data.notifications.user_id
      );

    const event = await insertData("events", {
      name: `Quick Match: ${userPersonalTeam.data[0].name} vs ${matchInvite.data.teams.name}`,
      quick_event: true,
    });

    const round = await insertData("rounds", {
      event_id: event[0].id,
      best_of: matchInvite.data.best_of,
      bans_per_match_participant: 0,
      name: `Quick Match: ${userPersonalTeam.data[0].name} vs ${matchInvite.data.teams.name}`,
    });

    const match = await insertData("matches", {
      ongoing: true,
      start_time: new Date(),
      round_id: round[0].id,
      type: "quick",
      map_pool_id: matchInvite.data.pool_id,
    });

    const matchQueue = await locals.supabase
      .from("match_queue")
      .select("*")
      .gt("position", 0);

    await insertData("match_queue", {
      match_id: match[0].id,
      position: matchQueue.data.length + 1,
    });

    await locals.supabase
      .from("notifications")
      .insert({
        user_id: matchInvite.data.teams.team_members[0].user_profiles.id,
        title: "Match Accepted",
        body: "Your match invite has been accepted!",
        href: `/matches/${match[0].id}/play`,
        type: "message",
      })
      .select("id")
      .single();

    const participant_1 = await insertData("participants", {
      team_id: userPersonalTeam.data[0].id,
      event_id: event[0].id,
    });

    const participant_2 = await insertData("participants", {
      team_id: matchInvite.data.sender_id,
      event_id: event[0].id,
    });

    const match_participant_1 = await locals.supabase
      .from("match_participants")
      .insert({
        match_id: match[0].id,
        participant_id: participant_1[0].id,
        surrendered_bans: true,
      })
      .select("*, participants(teams(team_members(*)))");

    const match_participant_2 = await locals.supabase
      .from("match_participants")
      .insert({
        match_id: match[0].id,
        participant_id: participant_2[0].id,
        surrendered_bans: true,
      })
      .select("*, participants(teams(team_members(*)))");

    insertData("match_participant_players", {
      match_participant_id: match_participant_1.data[0].id,
      team_member:
        match_participant_1.data[0].participants.teams.team_members[0].id,
      state: 1,
    });

    insertData("match_participant_players", {
      match_participant_id: match_participant_2.data[0].id,
      team_member:
        match_participant_2.data[0].participants.teams.team_members[0].id,
      state: 1,
    });
  },
  register: async ({ locals, request }) => {
    const formData = await request.formData();
    const teamId = formData.get("team-id");
    const eventId = formData.get("event-id");

    const participant = await locals.supabase.from("participants").insert([
      {
        team_id: teamId,
        event_id: eventId,
      },
    ]);

    console.log(participant);
  },
  logInEmail: async ({ request, locals: { supabase } }) => {
    const reqData = await request.formData();

    const { data, error } = await supabase.auth.signInWithPassword({
      email: reqData.get("email") as string,
      password: reqData.get("password") as string,
    });

    if (error) {
      return fail(error.status, {
        error: {
          message: error.message,
        },
      });
    }
  },
  logInOauth: async ({ request, url, locals: { supabase } }) => {
    const formData = await request.formData();
    const provider = formData.get("provider") as Provider;

    /**
     * Sign-in will not happen yet, because we're on the server-side,
     * but we need the returned url.
     */
    const { data, error } = await supabase.auth.signInWithOAuth({
      provider,
      options: {
        redirectTo: `${url.origin}/auth/callback`,
      },
    });

    if (error) {
      return fail(error.status, {
        error: {
          message: error.message,
        },
      });
    }

    /* Now authorize sign-in on browser. */
    if (data.url) redirect(303, data.url);
  },
  createMapPool: async ({ locals, request }) => {
    const formData = await request.formData();

    const mapPool = await locals.supabase
      .from("map_pools")
      .insert({
        name: formData.get("name"),
        description: formData.get("description"),
      })
      .select("*");

    if (mapPool.error) {
      return fail(500, {
        error: {
          message: mapPool.error.message,
        },
      });
    }

    throw redirect(303, `/map-pools/${mapPool.data[0].id}`);
  },
} satisfies Actions;
