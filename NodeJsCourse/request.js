const https = require("https");
const fs = require("fs");


const request = https.get("https://www.100chinaguide.com", res => {
    let download = fs.createWriteStream("./test.html")
    res.pipe(download)
    res.on('end', () => {
            console.log('File created')
        })


})
request.end()