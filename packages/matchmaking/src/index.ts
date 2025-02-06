import express from "express";
import { db } from "./db";
import {
  matches,
  matchParticipantPlayers,
  matchParticipants,
} from "./db/schema";

async function runMatchmaking() {}

async function createMatch(
  teams: { id: number; teamMemberIds: number[] }[],
  mapPoolId: number,
  bansPerMatchParticipant: number
) {
  await db.transaction(async (tx) => {
    const match = await tx
      .insert(matches)
      .values({
        mapPoolId,
        isRolling: true,
        currentBanner: null,
        bansPerMatchParticipant,
        currentPicker: null,
      })
      .returning();

    for (const team of teams) {
      const matchParticipant = await tx
        .insert(matchParticipants)
        .values({
          matchId: match[0].id,
          teamId: team.id,
        })
        .returning();

      for (const teamMemberId of team.teamMemberIds) {
        await tx.insert(matchParticipantPlayers).values({
          matchParticipantId: matchParticipant[0].id,
          teamMemberId,
        });
      }
    }
  });

  // await fetch("osu");
}

setInterval(() => {
  runMatchmaking();
}, 10000);

const app = express();
app.use(express.json());
const port = process.env.PORT || 3000;

app.get("/", (req, res) => {
  res.send("Express server is up and running!");
});

app.post("/create-match", async (req, res) => {
  const data = req.body;
  console.log("Creating match:", data);

  await createMatch(data.teams, data.mapPoolId, data.bansPerMatchParticipant);

  res.send("Match created");
});

app.listen(port, () => {
  console.log(`Express server listening on port ${port}`);
});
