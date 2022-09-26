const publicPath = "public";
const folder = "assets/plugins/";
const dist = publicPath + "/" + folder;
const mix = require("laravel-mix");

mix.js(__dirname + "/resources/js/notification.js", dist + "notification");
