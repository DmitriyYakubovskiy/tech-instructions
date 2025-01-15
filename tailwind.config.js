import defaultTheme from 'tailwindcss/defaultTheme';
<<<<<<< Updated upstream
=======
import forms from '@tailwindcss/forms';
>>>>>>> Stashed changes

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
<<<<<<< Updated upstream
        './resources/**/*.blade.php',
        './resources/**/*.js',
        './resources/**/*.vue',
    ],
=======
        './resources/views/**/*.blade.php',
    ],

>>>>>>> Stashed changes
    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
        },
    },
<<<<<<< Updated upstream
    plugins: [],
=======

    plugins: [forms],
>>>>>>> Stashed changes
};
