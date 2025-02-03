import { drizzle } from 'drizzle-orm'
async function main() {
    const db = drizzle('postgres-js', process.env.DATABASE_URL);
}
main();