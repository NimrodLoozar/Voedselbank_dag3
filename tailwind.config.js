// Laravel Project: /tailwind.config.js
import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],
    darkMode: 'class',
    theme: {
        extend: {
            colors: {
                primary: '#3B82F6',
                secondary: '#64748B',
                accent: '#FBBF24',
                neutral: '#374151',
                'base-100': '#FFFFFF',
                info: '#3ABFF8',
                success: '#36D399',
                warning: '#FBBD23',
                error: '#F87272',
            },
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
        },
    },
    variants: {
        extend: {
            backgroundColor: ['active'],
            textColor: ['active'],
            borderColor: ['active'],
        },
    },

    plugins: [forms],
};
