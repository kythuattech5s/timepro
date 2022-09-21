const publicPath = "public";
const folder = "assets/promotion/";
const dist = publicPath + "/" + folder;
const mix = require("laravel-mix");

// const tailwindcss = require("tailwindcss");
// mix.postCss(__dirname + "/resources/css/base.css",dist + "voucher/css");
// mix.postCss(__dirname + "/resources/css/style.css", dist + "voucher/css", [
//     tailwindcss("./tailwind.config.js"),
// ]);

// mix.js(__dirname + "/resources/js/voucher.js", dist + "voucher/js");
mix.ts(__dirname + "/resources/js/client.js", dist + "voucher/js");
