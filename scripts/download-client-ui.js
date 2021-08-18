const fs = require("fs");
const Downloader = require("nodejs-file-downloader");

const download = (url, fileName) => {
    if (fs.existsSync(`./src/${fileName}`)) return;

    const downloader = new Downloader({
        url,
        fileName,
        directory: "./src",
        cloneFiles: false,
    });
    downloader.download();
};

download("https://unpkg.com/@memorista/client-ui@2/dist/index.bundle.js", "memorista-client-ui.js");
