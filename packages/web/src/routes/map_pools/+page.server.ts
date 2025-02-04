import { osuMapPools } from '$lib/server/db/schema';
import { db } from '$lib/server/db';
import type { Actions, PageServerLoad } from './$types';

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

		await db.insert(osuMapPools).values({
			name: formData.get('name')
		});
	}
} satisfies Actions;
