import { drizzle } from "drizzle-orm/postgres-js";
import postgres from "postgres";
import * as schema from "./schema";

if (!process.env.DB_URL) throw new Error("DB_URL is not set");

const client = postgres(process.env.DB_URL);
export const db = drizzle(client, { schema });
