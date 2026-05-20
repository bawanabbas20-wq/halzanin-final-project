import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    darkMode: 'class',
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans:   ['Outfit', ...defaultTheme.fontFamily.sans],
                outfit: ['Outfit', 'sans-serif'],
                arabic: ['"Noto Naskh Arabic"', 'serif'],
                mono:   ['"JetBrains Mono"', 'monospace'],
            },
            colors: {
                brand: {
                    DEFAULT: '#1B4F8A',
                    light:   '#163F6E',
                    50:      '#EEF3FA',
                    100:     '#D6E4F5',
                },
                accent: {
                    DEFAULT: '#059669',
                    light:   '#d1fae5',
                },
                warm:    '#EFEDE8',
                charcoal:'#111111',
            },
            borderRadius: {
                sm:  '6px',
                md:  '10px',
                lg:  '16px',
                xl:  '24px',
            },
            keyframes: {
                slideUp: {
                    '0%':   { transform: 'translateY(60px)', opacity: '0' },
                    '100%': { transform: 'translateY(0)',    opacity: '1' },
                },
                fadeIn: {
                    '0%':   { opacity: '0' },
                    '100%': { opacity: '1' },
                },
            },
            animation: {
                'slide-up': 'slideUp 400ms cubic-bezier(0.22,1,0.36,1) 150ms both',
                'fade-in':  'fadeIn 400ms ease both',
                'fade-up':  'slideUp 500ms cubic-bezier(0.22,1,0.36,1) both',
            },
            boxShadow: {
                'brand-btn':       '0 4px 14px rgba(27,79,138,0.30)',
                'brand-btn-hover': '0 6px 20px rgba(27,79,138,0.40)',
            },
        },
    },

    plugins: [forms],
};
