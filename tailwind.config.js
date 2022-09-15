/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        "./public/page-custom/*.html",
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./packages/**/*.blade.php",
        "./packages/**/*.js",
    ],
    theme: {
        extend: {},
    },
    plugins: [],
};
