const publicPath = "public";
const folder = "admin/promotion";
const dist = publicPath + "/" + folder;
const mix = require("laravel-mix");

const tailwindcss = require("tailwindcss");

mix.postCss(__dirname + "/resources/css/app.css", dist + "/css", [
    tailwindcss("./tailwind.config.js"),
]);

mix.copyDirectory(__dirname + "/resources/assets", dist + "/assets");