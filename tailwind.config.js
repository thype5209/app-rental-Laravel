const defaultTheme = require('tailwindcss/defaultTheme');

/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Poppins', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                'default-yellow': '#F1A02F',
                'default-red': '#CF4647',
                'default-dark': '#2A363B',
                'default-white': '#F8F6F6',
            }
        },
    },

    plugins: [require('@tailwindcss/forms')],
};
