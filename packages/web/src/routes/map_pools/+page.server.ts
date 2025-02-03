import { osuMapPools } from '$lib/server/db/schema';
import { db } from '$lib/server/db';
import type { PageServerLoad } from './$types';

export const load: PageServerLoad = async () => {
	return {
		mapPools: await db.select().from(osuMapPools)
	};
};
