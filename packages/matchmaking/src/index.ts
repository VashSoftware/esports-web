import express from "express";
import { db } from "./db";
import {
  matches,
  matchParticipantPlayers,
  matchParticipants,
} from "./db/schema";

async function runMatchmaking() {}

async function createMatch(
  matchParticipantIds: number[],
  matchParticipantPlayerIds: number[],
  mapPoolId: number,
  bansPerMatchParticipant: number
) {
  await db.transaction(async (tx) => {
    await tx
      .insert(matches)
      .values({
        isRolling: true,
        currentBanner: null,
        currentPicker: null,
      })
      .returning();

    await tx
      .insert(matchParticipants)
      .values(
        matchParticipantIds.map((mp) => {
          return {
            matchId: 1,
          };
        })
      )
      .returning();

    await tx.insert(matchParticipantPlayers).values({}).returning();
  });

  await fetch("osu");
}

setInterval(() => {
  runMatchmaking();
}, 10000);

const app = express();
const port = process.env.PORT || 3000;

app.get("/", (req, res) => {
  res.send("Express server is up and running!");
});

app.post("/create-match", async (req, res) => {
  const data = req.body;
  console.log("Creating match:", data);

  await createMatch(
    data.matchParticipantIds,
    data.matchParticipantPlayerIds,
    data.mapPoolId,
    data.bansPerMatchParticipant
  );

  res.send("Match created");
});

app.listen(port, () => {
  console.log(`Express server listening on port ${port}`);
});
