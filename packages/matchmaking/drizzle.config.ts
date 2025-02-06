import { defineConfig } from 'drizzle-kit';
if (!process.env.DB_URL) throw new Error('DB_URL is not set');

export default defineConfig({
	schema: './src/db/schema.ts',

	dbCredentials: {
		url: process.env.DB_URL
	},

	verbose: true,
	strict: true,
	dialect: 'postgresql'
});
