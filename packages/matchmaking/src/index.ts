import express from "express";

async function runMatchmaking() {
  console.log("Running matchmaking");
}

setInterval(() => {
  runMatchmaking();
}, 10000);

const app = express();
const port = process.env.PORT || 3000;

app.get("/", (req, res) => {
  res.send("Express server is up and running!");
});

app.listen(port, () => {
  console.log(`Express server listening on port ${port}`);
});
