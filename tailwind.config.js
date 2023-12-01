/** @type {import('tailwindcss').Config} */

module.exports = {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
        "./vueform.config.js", // or where `vueform.config.js` is located. Change `.js` to `.ts` if required.
        "./node_modules/@vueform/vueform/themes/tailwind/**/*.vue",
        "./node_modules/@vueform/vueform/themes/tailwind/**/*.js",
    ],
    theme: {
        extend: {
            colors: {
                dark: "#070703",
                primary: "#FDD102",
            },
        },
    },
    plugins: [require("@vueform/vueform/tailwind")],
};
