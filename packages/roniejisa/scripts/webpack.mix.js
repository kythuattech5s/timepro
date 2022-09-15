const publicPath = "public";
const namePath = "assets";
const path = require("path");
const dist = publicPath + "/" + namePath;
let mix = require("laravel-mix");

mix.copyDirectory(__dirname + "/assets", dist);
