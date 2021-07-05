const Downloader = require("nodejs-file-downloader");
const fs = require("fs");

const download = (url, fileName) => {
    if (fs.existsSync(`./src/${fileName}`)) {
        return;
    }

    const downloader = new Downloader({
        url,
        fileName,
        directory: "./src",
        cloneFiles: false,
    });
    downloader.download();
};

download("https://unpkg.com/@memorista/client-ui@1/dist/index.js", "memorista-client-ui.js");
download("https://unpkg.com/@memorista/client-ui@1/dist/index.css", "memorista-client-ui.css");
