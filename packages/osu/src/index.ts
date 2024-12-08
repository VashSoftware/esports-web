import { Client } from "irc";
import express from "express";

function setupIrc() {
  const client = new Client("irc.ppy.sh", process.env.IRC_USERNAME, {
    channels: ["#osu"],
    userName: process.env.IRC_USERNAME,
    password: process.env.IRC_PASSWORD,
  });

  client.addListener("error", function (message) {
    console.error("error: ", message);
  });

  client.addListener("registered", function (message) {
    console.log("Registered", message);
  });

  client.addListener("message", function (from, to, message) {
    console.log(from + " => " + to + ": " + message);
  });

  return client;
}

function setupExpress(ircClient) {
  const app = express();
  app.use(express.json());

  app.post("/send-message", (req, res) => {
    const data = req.body;

    ircClient.say("#osu", data.message);

    res.send("Message sent");
  });

  app.listen(3000, () => {
    console.log("Express server listening on port 3000");
  });
}

const client = setupIrc();
setupExpress(client);
