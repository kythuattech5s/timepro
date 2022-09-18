let glob = require("glob");

glob.sync("./packages/**/webpack.mix.js").forEach((file) => require(file));

let mix = require("laravel-mix");
const tailwindcss = require("tailwindcss");

mix.postCss("resources/css/app.css", "/css", [
    tailwindcss("./tailwind.config.js"),
]);
