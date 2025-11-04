import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.js',
    ],

    theme: {
        extend: {
            colors: {
                'brand-primary': '#eb5120',
                'brand-secondary': '#f2d52c',
                'brand-ink': '#1e3a8a',
                'brand-light': '#f6e6bc',
                'brand-pale': '#fff9ec',
            },
            boxShadow: {
                soft: '0 16px 42px rgba(30, 58, 138, 0.12)',
                'soft-sm': '0 10px 26px rgba(30, 58, 138, 0.09)',
            },
            fontFamily: {
                sans: ['Lato', 'Poppins', 'Inter', 'Questrial', ...defaultTheme.fontFamily.sans],
                body: ['Lato', 'Poppins', 'Inter', 'Questrial', ...defaultTheme.fontFamily.sans],
            },
        },
    },

    plugins: [forms],
};
