import { osuMapPools } from '$lib/server/db/schema';
import { db } from '$lib/server/db';
import type { PageServerLoad } from './$types';
import { eq } from 'drizzle-orm';

export const load: PageServerLoad = async ({ params }) => {
	return {
		mapPool: await db.query.osuMapPools.findFirst({
			where: eq(osuMapPools.id, parseInt(params.id)),
			with: {
				osuMapPoolMaps: true
			}
		})
	};
};
