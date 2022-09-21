const publicPath = "public";
const folder = "assets/promotion/";
const dist = publicPath + "/" + folder;
const mix = require("laravel-mix");

const tailwindcss = require("tailwindcss");
mix.css(__dirname + "/resources/css/base.css", dist + "flashsale/css");
mix.postCss(__dirname + "/resources/css/style.css", dist + "flashsale/css", [
    tailwindcss("./tailwind.config.js"),
]);

mix.js(__dirname + "/resources/js/flashsale.js", dist + "flashsale/js");
