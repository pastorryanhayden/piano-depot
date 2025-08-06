import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';
import daisyui from 'daisyui';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
                'playfair': ['Playfair Display', 'serif'],
                'montserrat': ['Montserrat', 'sans-serif'],
            },
        },
    },

    plugins: [forms, daisyui],
    
    daisyui: {
        themes: [
            {
                light: {
                    "primary": "#1e40af",
                    "secondary": "#64748b",
                    "accent": "#f59e0b",
                    "neutral": "#1f2937",
                    "base-100": "#ffffff",
                    "info": "#3b82f6",
                    "success": "#10b981",
                    "warning": "#f59e0b",
                    "error": "#ef4444",
                },
            },
            "dark",
        ],
    },
};
