import { Server } from "socket.io";

const io = new Server({
  cors: {
    origin: "http://localhost",
  },
});

io.on("connection", (socket) => {
  console.log("A user connected: ", socket.id);
});

io.listen(3000);
console.log("Listening on port 3000");
