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
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
                brand: ['Inter', 'sans-serif'],
            },
            // WARNA CUSTOM
            colors: {
                brand: {
                    dark: '#009a7b',    
                    primary: '#009a7b', 
                    soft: '#e8f5e9',    
                    accent: '#F59E0B',  
                    gray: '#F8FAFC',    
                    input: '#F1F5F9',   
                }
            },
            boxShadow: {
                'glow': '0 0 20px rgba(0, 154, 123, 0.5)',
            }
        },
    },

    plugins: [forms, typography],
};
