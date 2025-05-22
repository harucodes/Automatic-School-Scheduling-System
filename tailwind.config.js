import defaultTheme from "tailwindcss/defaultTheme";
import forms from "@tailwindcss/forms";

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/views/**/*.blade.php",
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ["Figtree", ...defaultTheme.fontFamily.sans],
            },
            colors: {
                maroon: {
                    100: "#f3dede",
                    200: "#e0bdbd",
                    600: "#9b1a1a",
                    800: "#660000",
                },
                mustard: {
                    100: "#fff4cc",
                    600: "#ffc438",
                },
            },
        },
    },

    plugins: [forms],
    darkMode: "class",
};
