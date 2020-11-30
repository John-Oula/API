const { Server } = require("ws");

const wss = new Server({port:'3000'})

let msgs = []
wss.on("connection" , socket => {
    socket.on("message", msg =>{
        console.log(msg)
        msgs.push(msg)
        wss.clients.forEach(client => client.send(msg))
    })
    socket.on("close", ()=> {
        console.log("Disconnected")
    })
    socket.send('Antratech')
    console.log("new socket connected")
    if(msgs.length){
        msgs.forEach(msg => socket.send(msg))

    }
})
console.log("waiting ws://localhost:3000")