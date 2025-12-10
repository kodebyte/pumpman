import './bootstrap';

import Alpine from 'alpinejs';
import { createIcons, icons } from 'lucide';

window.Alpine = Alpine;
Alpine.start();

document.addEventListener('DOMContentLoaded', () => {
    // 1. Initialize Lucide Icons
    createIcons({ icons });

    // 2. Navbar Scroll Effect
    const navbar = document.getElementById('navbar');
    // Cek apakah elemen ada (untuk menghindari error di halaman tanpa navbar)
    if (navbar) {
        window.addEventListener('scroll', () => {
            if (window.scrollY > 50) {
                navbar.classList.remove('bg-transparent', 'text-white', 'py-6');
                navbar.classList.add('bg-white/90', 'backdrop-blur-md', 'text-black', 'shadow-sm', 'py-4');
            } else {
                navbar.classList.add('bg-transparent', 'text-white', 'py-6');
                navbar.classList.remove('bg-white/90', 'backdrop-blur-md', 'text-black', 'shadow-sm', 'py-4');
            }
        });
    }

    // 3. Mobile Menu Toggle
    const mobileMenuBtn = document.getElementById('mobile-menu-btn');
    const mobileMenu = document.getElementById('mobile-menu');

    if (mobileMenuBtn && mobileMenu) {
        mobileMenuBtn.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
            mobileMenu.classList.toggle('flex');
            
            // Opsional: Ubah warna navbar jadi solid saat menu dibuka di posisi paling atas
            if (!mobileMenu.classList.contains('hidden') && window.scrollY <= 50) {
                 navbar.classList.remove('bg-transparent', 'text-white');
                 navbar.classList.add('bg-white', 'text-black');
            } else if (mobileMenu.classList.contains('hidden') && window.scrollY <= 50) {
                 navbar.classList.add('bg-transparent', 'text-white');
                 navbar.classList.remove('bg-white', 'text-black');
            }
        });
    }
});