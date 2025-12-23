import './bootstrap';

import Alpine from 'alpinejs';
import collapse from '@alpinejs/collapse';
import { createIcons, icons } from 'lucide';

document.addEventListener("DOMContentLoaded", () => {
    createIcons({ icons });
});

window.Alpine = Alpine;
Alpine.plugin(collapse);
Alpine.start();
