import { users } from '$lib/server/db/schema';
import { db } from '$lib/server/db';
import type { PageServerLoad } from './$types';
import { eq } from 'drizzle-orm';
import { error } from '@sveltejs/kit';

export const load: PageServerLoad = async ({ params }) => {
	const user = await db.query.users.findFirst({
		where: eq(users.id, params.id)
	});

	if (!user) {
		error(404, 'User not found');
	}

	return {
		user
	};
};
