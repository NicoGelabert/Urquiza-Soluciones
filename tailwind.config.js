import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Plus Jakarta Sans', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                brand: {
                    50: '#f2f7fa',
                    100: '#c9dceb',
                    200: '#9bbdd4',
                    300: '#5c96b8',
                    400: '#2d75a3',
                    500: '#195b87',
                    600: '#124d74',
                    700: '#0c3f61',
                    800: '#07324f',
                    900: '#04263d',
                    950: '#011627',
                },
            },
            boxShadow: {
                soft: '0 4px 24px -4px rgb(15 23 42 / 0.08)',
                card: '0 1px 3px rgb(15 23 42 / 0.06), 0 8px 24px -8px rgb(15 23 42 / 0.1)',
            },
        },
    },

    plugins: [forms],
};
