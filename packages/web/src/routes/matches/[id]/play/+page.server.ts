import { db } from '$lib/server/db';
import { eq } from 'drizzle-orm';
import type { PageServerLoad } from './$types';
import { matches } from '$lib/server/db/schema';
import { error } from '@sveltejs/kit';

export const load: PageServerLoad = async ({ params }) => {
	const match = await db.query.matches.findFirst({
		where: eq(matches.id, params.id),
		with: {
			participants: {
				with: {
					players: true
				}
			},
			mapPool: {
				with: {
					maps: true
				}
			},
			picks: {
				with: {
					mapPoolMap: true
				}
			}
		}
	});

	if (!match) {
		error(404, 'Match not found');
	}

	return {
		match,
		maps: []
	};
};
