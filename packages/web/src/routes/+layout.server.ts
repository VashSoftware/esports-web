import { db } from '$lib/server/db';
import { eq } from 'drizzle-orm';
import type { LayoutServerLoad } from './$types';
import { teamMembers } from '$lib/server/db/schema';

export const load: LayoutServerLoad = async ({ locals: { safeGetSession }, cookies }) => {
	const { session } = await safeGetSession();
	return {
		session,
		cookies: cookies.getAll(),
		currentMatches: await db.query.matches.findMany({
			with: {
				participants: {
					with: {
						players: {
							with: {
								teamMember: {
									where: eq(teamMembers.userId, session?.user.id)
								}
							}
						}
					}
				}
			}
		})
	};
};
