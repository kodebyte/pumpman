import './bootstrap';
import Alpine from 'alpinejs';

// Logic khusus Admin Product Form (Tab Switcher, Image Preview)
// Kita bisa pindahkan logic x-data="productForm" ke sini agar lebih rapi
document.addEventListener('alpine:init', () => {
    Alpine.data('productForm', (config) => ({
        activeTab: config.initialTab,
        discountType: config.discountType,
        hasVariants: config.hasVariants,
        variants: config.variants,
        imgPreviews: [],
        imagesToDelete: [],
        downloadsToDelete: [],

        // ... (copy logic JS dari create/edit.blade.php sebelumnya ke sini jika ingin clean) ...
        handleFileSelect(event) {
            const files = event.target.files;
            this.imgPreviews = [];
            for (let i = 0; i < files.length; i++) {
                const file = files[i];
                const reader = new FileReader();
                reader.onload = (e) => {
                    this.imgPreviews.push({ url: e.target.result, name: file.name });
                };
                reader.readAsDataURL(file);
            }
        },

        removeNewImage(index) {
            const input = document.getElementById('images');
            const dt = new DataTransfer();
            const { files } = input;
            for (let i = 0; i < files.length; i++) {
                if (index !== i) dt.items.add(files[i]);
            }
            input.files = dt.files;
            this.imgPreviews.splice(index, 1);
        },

        toggleDeleteImage(id) {
            if (this.imagesToDelete.includes(id)) {
                this.imagesToDelete = this.imagesToDelete.filter(item => item !== id);
            } else {
                this.imagesToDelete.push(id);
            }
        },
        
        isDeleted(id) {
            return this.imagesToDelete.includes(id);
        },

        toggleDeleteDownload(id) {
            if (this.downloadsToDelete.includes(id)) {
                this.downloadsToDelete = this.downloadsToDelete.filter(item => item !== id);
            } else {
                this.downloadsToDelete.push(id);
            }
        },

        isDownloadDeleted(id) {
            return this.downloadsToDelete.includes(id);
        },
    }));
});

window.Alpine = Alpine;
Alpine.start();