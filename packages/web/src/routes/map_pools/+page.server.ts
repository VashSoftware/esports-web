import { osuMapPools } from '$lib/server/db/schema';
import { db } from '$lib/server/db';
import type { Actions, PageServerLoad } from './$types';
import { redirect } from '@sveltejs/kit';

export const load: PageServerLoad = async () => {
	return {
		mapPools: await db.select().from(osuMapPools)
	};
};

export const actions = {
	createMapPool: async ({ request }) => {
		const formData = await request.formData();

		if (!formData.has('name')) {
			return {
				status: 400,
				body: 'Name is required'
			};
		}

		const mapPool = await db
			.insert(osuMapPools)
			.values({
				name: formData.get('name')
			})
			.returning();

		if (!mapPool) {
			return {
				status: 500,
				body: 'Failed to create map pool'
			};
		}

		redirect(303, `/map_pools/${mapPool[0].id}`);
	}
} satisfies Actions;
