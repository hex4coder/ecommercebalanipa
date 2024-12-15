import defaultTheme from "tailwindcss/defaultTheme";
import forms from "@tailwindcss/forms";
import preset from "./vendor/filament/support/tailwind.config.preset";


/** @type {import('tailwindcss').Config} */
export default {
    presets: [preset],
    content: [
        "./resources/views/**/*.blade.php",
        "./node_modules/preline/dist/*.js",
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/views/filament/**/*.blade.php",
        // penambahan untuk filament
        "./app/Filament/**/*.php",
        "./vendor/filament/**/*.blade.php",


    ],

    darkMode: 'class',

    theme: {
        extend: {
            fontFamily: {
                sans: ["Figtree", ...defaultTheme.fontFamily.sans],
            },
            colors: {
                'gray': preset.theme.extend.colors.gray,
            }
        },
    },

    plugins: [forms, require("preline/plugin")],
};
