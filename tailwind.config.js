module.exports = {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
        "./node_modules/flowbite/**/*.js",
        "node_modules/preline/dist/*.js",
    ],
    theme: {
        extend: {
            fontFamily: {
                sans: ["Spline Sans", "sans-serif"],
            },
            zIndex: { 
                "35" : "35",
            }
        },
    },
    plugins: [require("flowbite/plugin")],
};
