const publicPath = "public";
const folder = "video";
const dist = publicPath + "/" + folder;
const mix = require("laravel-mix");

const tailwindcss = require("tailwindcss");

mix.postCss(__dirname + "/resources/css/video.css", dist + "/css", [
    tailwindcss("./tailwind.config.js"),
]);

mix.js(__dirname + "/resources/js/video.js", dist + "/js");
