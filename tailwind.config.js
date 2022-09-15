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
        extend: {
            screens: {
                sm: "576px",
                md: "768px",
                lg: "1024px",
                xl: "1280px",
                "2xl": "1408px",
            },
        },
    },
    plugins: [],
};
