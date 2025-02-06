import { osuMapPoolMaps, osuMapPools } from '$lib/server/db/schema';
import { db } from '$lib/server/db';
import type { Actions, PageServerLoad } from './$types';
import { eq } from 'drizzle-orm';

export const load: PageServerLoad = async ({ params }) => {
	return {
		mapPool: await db.query.osuMapPools.findFirst({
			where: eq(osuMapPools.id, parseInt(params.id)),
			with: {
				maps: true
			}
		})
	};
};

export const actions = {
	addMap: async ({ params, request }) => {
		const formData = await request.formData();

		await db.insert(osuMapPoolMaps).values({
			osuMapPoolId: parseInt(params.id)
		});
	}
} satisfies Actions;
