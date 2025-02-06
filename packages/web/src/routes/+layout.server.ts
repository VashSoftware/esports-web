import { db } from '$lib/server/db';
import { eq } from 'drizzle-orm';
import type { LayoutServerLoad } from './$types';
import { teamMembers, users } from '$lib/server/db/schema';

export const load: LayoutServerLoad = async ({ locals: { safeGetSession }, cookies }) => {
	const { session } = await safeGetSession();
	return {
		session,
		cookies: cookies.getAll(),
		user: await db.query.users.findFirst({
			where: eq(users.id, session?.user.id),
			with: {
				teamMembers: true
			}
		}),
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
