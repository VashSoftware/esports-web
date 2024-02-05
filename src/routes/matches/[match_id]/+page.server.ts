import type { Actions, PageServerLoad } from "./$types";

export const load: PageServerLoad = async ({ locals, params, url }) => {
  const { data, error } = await locals.supabase
    .from("matches")
    .select(
      `*,
      rounds ( best_of, events (id, name, event_links(*, platforms(*)))),
      match_participants(points, participants(id, teams(id, name, team_members(*, user_profiles(*))))),
      match_maps(maps(*, mapsets(*)),
      scores(*)),
      match_predictions(*)`
    )
    .eq("id", params.match_id)
    .single();

  console.log(error);

  const changes = await locals.supabase
    .channel("schema-db-changes")
    .on(
      "postgres_changes",
      {
        event: "*",
        schema: "public",
      },
      (payload) => console.log(payload)
    )
    .subscribe();

  return {
    match: data,
    hostname: url.hostname,
  };
};

export const actions = {
  default: async ({ locals, params, request }) => {
    const formData = await request.formData();
    const teamId = formData.get("participantId");

    const existingPrediction = await locals.supabase
      .from("match_predictions")
      .select("*")
      .eq("match_id", params.match_id)
      .eq("user_id", locals.user.id);
    if (existingPrediction.data.length > 0) {
      return false;
    }

    await locals.supabase.from("match_predictions").upsert({
      match_id: params.match_id,
      user_id: locals.user.id,
      winning_participant_id: teamId,
    });
  },
} satisfies Actions;
