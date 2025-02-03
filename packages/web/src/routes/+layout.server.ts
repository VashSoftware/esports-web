import * as db from '$lib/server/db';
import type { LayoutServerLoad } from './$types';

export const load: LayoutServerLoad = async () => {
	return {
		user: {}
	};
};
