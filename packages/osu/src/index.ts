import { Client } from "irc";
import express from "express";
import axios from "axios";

function setupIrc() {
  const client = new Client("irc.ppy.sh", process.env.IRC_USERNAME!, {
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

  client.addListener("message", async function (from, to, message) {
    try {
      await axios.post("http://laravel.test/api/osu_messages", {
        username: from,
        channel: to,
        message,
      });
    } catch (error) {
      console.error("Failed to send message to Laravel API:", error.response ? error.response.data : error.message);
    }
  });

  return client;
}

function setupExpress(ircClient: Client) {
  const app = express();
  app.use(express.json());

  app.post("/send-message", (req, res) => {
    const data = req.body;

    console.log(`Sending message to ${data.channel}: ${data.message}`);
    ircClient.say(data.channel, data.message);

    res.send("Message sent");
  });

  app.listen(3000, () => {
    console.log("Express server listening on port 3000");
  });
}

const client = setupIrc();
setupExpress(client);
