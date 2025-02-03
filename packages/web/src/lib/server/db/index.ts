import { drizzle } from 'drizzle-orm/postgres-js';
import postgres from 'postgres';
import { env } from '$env/dynamic/private';
if (!env.DB_URL) throw new Error('DB_URL is not set');
const client = postgres(env.DB_URL);
export const db = drizzle(client);
