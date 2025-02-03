import { scores, teams, users } from '$lib/server/db/schema';
import { db } from '$lib/server/db';
import type { PageServerLoad } from './$types';

export const load: PageServerLoad = async () => {
	return {
		top_players: await db.select().from(users),
		top_teams: await db.select().from(teams),
		top_scores: await db.select().from(scores)
	};
};
