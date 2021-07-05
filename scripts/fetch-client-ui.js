const Downloader = require("nodejs-file-downloader");

const download = (url, fileName) => {
    const downloader = new Downloader({
        url,
        fileName,
        directory: "./src",
        cloneFiles: false,
    });

    return downloader.download();
};

download("https://unpkg.com/@memorista/client-ui@1/dist/index.js", "memorista-client-ui.js");
download("https://unpkg.com/@memorista/client-ui@1/dist/index.css", "memorista-client-ui.css");
