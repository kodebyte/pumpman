import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';
import typography from '@tailwindcss/typography';

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
                // 1. Font Default / Admin (Figtree)
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
                
                // 2. Font Khusus Frontend (Inter)
                // Kita beri nama 'brand' atau 'inter'
                brand: ['Inter', 'sans-serif'],
            },
            // WARNA CUSTOM
            colors: {
                aiwaRed: '#E60012',
                charcoal: '#1a1a1a',
                softGray: '#F8F9FA'
            },
            // ANIMASI CUSTOM
            animation: {
                'pulse-slow': 'pulse 4s cubic-bezier(0.4, 0, 0.6, 1) infinite',
                'marquee': 'marquee 25s linear infinite',
                'fade-in-up': 'fadeInUp 1s ease-out forwards',
            },
            // KEYFRAMES
            keyframes: {
                marquee: {
                    '0%': { transform: 'translateX(0%)' },
                    '100%': { transform: 'translateX(-100%)' },
                },
                fadeInUp: {
                    '0%': { opacity: '0', transform: 'translateY(20px)' },
                    '100%': { opacity: '1', transform: 'translateY(0)' },
                }
            }
        },
    },

    plugins: [forms, typography],
};
