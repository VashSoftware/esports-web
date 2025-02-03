import { Server } from "socket.io";

const io = new Server({
  /* options */
});

io.on("connection", (socket) => {
  // ...
});

io.listen(3000);
console.log("Listening on port 3000");
