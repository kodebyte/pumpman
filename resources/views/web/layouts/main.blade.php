<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    @php
        // --- 1. OTOMATISASI PENGAMBILAN KEY ---
        
        // Cek apakah controller mengirim $page secara manual? (Opsional/Override)
        // Jika tidak, AMBIL OTOMATIS dari nama route saat ini.
        $currentRouteName = request()->route()->getName(); // Contoh output: 'pages.about' atau 'products.index'
        
        // Gunakan variabel $page jika ada, jika tidak pakai route name otomatis
        $seoKey = $page ?? $currentRouteName;

        // --- 2. AMBIL DARI DATABASE ---
        $seoSetting = App\Models\SeoSetting::getByRoute($seoKey);

        // --- 3. PRIORITAS NILAI (Controller > DB > Config) ---
        
        // Title
        $metaTitle = $title 
                     ?? $seoSetting?->getTranslation('meta_title') 
                     ?? config('app.name');

        // Description
        $metaDescription = $description 
                           ?? $seoSetting?->getTranslation('meta_description') 
                           ?? __('Pumpman Indonesia Official Store');

        // Image
        $dbImage = $seoSetting?->og_image ? asset('storage/' . $seoSetting->og_image) : null;
        $metaImage = $image ?? $dbImage ?? asset('assets/web/images/logo-aiwa.png');
    @endphp

    <title>{{ $metaTitle }}</title>
    <meta name="description" content="{{ $metaDescription }}">

    <meta property="og:title" content="{{ $metaTitle }}" />
    <meta property="og:description" content="{{ $metaDescription }}" />
    <meta property="og:image" content="{{ $metaImage }}" />
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-brand antialiased text-gray-900 bg-white selection:bg-yellow-400 selection:text-black">

    @include('web.layouts.partials.navbar')

    <main>
        {{ $slot }}
    </main>

    @include('web.layouts.partials.footer')

    <div x-data="{ isOpen: false }" class="fixed bottom-6 right-6 z-[9999] font-sans group">
        <div x-show="isOpen"
            x-cloak
            x-transition:enter="transition ease-out duration-300 transform origin-bottom-right"
            x-transition:enter-start="opacity-0 scale-90 translate-y-2"
            x-transition:enter-end="opacity-100 scale-100 translate-y-0"
            x-transition:leave="transition ease-in duration-200 transform origin-bottom-right"
            x-transition:leave-start="opacity-100 scale-100 translate-y-0"
            x-transition:leave-end="opacity-0 scale-90 translate-y-2"
            @click.outside="isOpen = false"
            class="absolute bottom-20 right-0 w-[300px] bg-white rounded-2xl shadow-2xl overflow-hidden">
            
            <div class="bg-brand-dark p-5 relative overflow-hidden">
                <div class="absolute top-0 right-0 w-24 h-24 bg-white/10 rounded-full -translate-y-1/2 translate-x-1/2"></div>
                <h3 class="text-white font-bold text-lg relative z-10">Hello, Pumpman here! 👋</h3>
                <p class="text-white/80 text-xs mt-1 relative z-10">Need help with pumps? Chat with our team below.</p>
            </div>

            <div class="p-4 space-y-3">
                @if(isset($whatsappContacts) && $whatsappContacts->count() > 0)
                    @foreach($whatsappContacts as $contact)
                        <a href="{{ $contact->whatsapp_url }}" target="_blank" class="flex items-center gap-4 p-3 rounded-xl hover:bg-brand-soft/50 transition-colors group/item">
                            <div class="relative">
                                {{-- Dynamic Color & Icon --}}
                                {{-- Pastikan class warna seperti bg-green-100, text-blue-600 ter-generate oleh Tailwind --}}
                                <div class="w-10 h-10 rounded-full bg-{{ $contact->color }}-100 flex items-center justify-center text-{{ $contact->color }}-600">
                                    <i data-lucide="{{ $contact->icon }}" class="w-5 h-5"></i>
                                </div>
                                {{-- Online Indicator (Selalu hijau untuk memberi kesan aktif) --}}
                                <div class="absolute bottom-0 right-0 w-3 h-3 bg-green-500 border-2 border-white rounded-full"></div>
                            </div>
                            <div>
                                <h4 class="font-bold text-slate-800 text-sm group-hover/item:text-brand-primary transition">
                                    {{ $contact->title }}
                                </h4>
                                @if($contact->subtitle)
                                    <p class="text-xs text-slate-500">{{ $contact->subtitle }}</p>
                                @endif
                            </div>
                            <i data-lucide="chevron-right" class="w-4 h-4 text-slate-300 ml-auto group-hover/item:text-brand-primary"></i>
                        </a>
                    @endforeach
                @else
                    {{-- Fallback jika belum ada data --}}
                    <div class="text-center py-4">
                        <p class="text-xs text-gray-400">{{ __('No contacts available yet.') }}</p>
                    </div>
                @endif
            </div>

            <div class="bg-gray-50 p-3 text-center border-t border-gray-100">
                <p class="text-[10px] text-slate-400">Available Mon-Fri, 08:00 - 17:00</p>
            </div>
        </div>

        <button @click="isOpen = !isOpen" 
                class="flex items-center justify-center w-14 h-14 bg-[#25D366] hover:bg-[#20bd5a] text-white rounded-full shadow-lg hover:shadow-green-500/40 transition-all duration-300 transform hover:scale-110 focus:outline-none relative">
            
            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" 
                class="absolute transition-all duration-300"
                :class="isOpen ? 'opacity-0 -rotate-90' : 'opacity-100 rotate-0'">
                <path d="M7.9 20A9 9 0 1 0 4 16.1L2 22Z"></path>
            </svg>
            
            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" 
                class="absolute transition-all duration-300"
                :class="isOpen ? 'opacity-100 rotate-0' : 'opacity-0 rotate-90'">
                <path d="M18 6 6 18"></path>
                <path d="m6 6 12 12"></path>
            </svg>
        </button>
    </div>

    @stack('scripts')

    <script>
        let lastScroll = 0;
        const header = document.getElementById('navbar'); // ID navbar
        const scrollThreshold = 10; // Toleransi sensitivitas

        if (header) {
            window.addEventListener('scroll', () => {
                const currentScroll = window.pageYOffset;
                // Ambil tinggi navbar secara dinamis (termasuk top bar jika ada)
                const headerHeight = header.offsetHeight; 

                // 0. Abaikan scroll negatif (bounce effect iOS)
                if (currentScroll < 0) return;

                // 1. Logic Delta: Abaikan jika scroll terlalu sedikit (micro-scroll)
                if (Math.abs(currentScroll - lastScroll) < scrollThreshold) {
                    return;
                }

                // 2. LOGIC BARU: BUFFER ZONE
                // Jika posisi scroll masih kurang dari tinggi navbar (plus buffer sedikit),
                // PAKSA navbar tetap terlihat (translateY 0).
                // Ini mencegah navbar hilang saat user masih di area paling atas (Top Header).
                if (currentScroll <= (headerHeight + 20)) { 
                    header.style.transform = "translateY(0)";
                }
                // 3. Scroll ke Bawah DAN sudah melewati tinggi navbar: Sembunyikan
                else if (currentScroll > lastScroll) {
                    header.style.transform = "translateY(-100%)"; 
                } 
                // 4. Scroll ke Atas: Tampilkan
                else {
                    header.style.transform = "translateY(0)"; 
                }
                
                lastScroll = currentScroll;
            });
        }

        document.addEventListener('alpine:init', () => {
           window.addToCart = async function(productId, qty = 1, variantId = null, imageId = null) {
                return new Promise(async (resolve, reject) => {
                    try {
                        const response = await fetch('{{ route('cart.add') }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Accept': 'application/json'
                            },
                            body: JSON.stringify({
                                product_id: productId,
                                variant_id: variantId,
                                qty: qty
                            })
                        });

                        // 1. Parse JSON terlebih dahulu
                        const data = await response.json();

                        // 2. Cek status sukses atau gagal
                        if (!response.ok || !data.success) {
                            // Gunakan pesan error dari server atau pesan default yang diterjemahkan
                            throw new Error(data.message || "{{ __('Failed to add to cart.') }}");
                        }

                        // --- Jika Sukses ---
                        
                        // Animasi
                        if (imageId) {
                            const imgEl = document.getElementById(imageId);
                            if (imgEl && window.runFlyAnimation) {
                                window.runFlyAnimation(imgEl);
                            }
                        }

                        // Update Navbar Cart Count
                        if(Alpine.store('cart')) {
                            Alpine.store('cart').updateCount(data.cart_count);
                        }

                        // Toast Sukses
                        if (window.showToast) {
                            window.showToast(data.message);
                        }
                        
                        resolve(data);

                    } catch (error) {
                        console.error(error);
                        
                        if(error.message.includes('Unauthenticated') || error.status === 401) {
                            window.location.href = '{{ route("login") }}';
                        } else {
                            alert(error.message); 
                        }
                        reject(error);
                    }
                });
            };

            // 2. HELPER ANIMASI
            window.runFlyAnimation = function(sourceElement) {
                const cartIcon = document.getElementById('cart-icon-target');
                if (!sourceElement || !cartIcon) return;

                const clone = sourceElement.cloneNode(true);
                clone.setAttribute('x-ignore', '');
                clone.removeAttribute('id');
                clone.removeAttribute(':src');
                clone.removeAttribute(':class');
                clone.removeAttribute(':style');
                clone.removeAttribute('x-ref');
                
                clone.src = sourceElement.src;
                clone.className = 'fixed z-[9999] object-contain mix-blend-multiply rounded-full pointer-events-none opacity-100';
                
                const start = sourceElement.getBoundingClientRect();
                const end = cartIcon.getBoundingClientRect();

                clone.style.top = start.top + 'px';
                clone.style.left = start.left + 'px';
                clone.style.width = start.width + 'px';
                clone.style.height = start.height + 'px';
                clone.style.transition = 'all 1s cubic-bezier(0.25, 1, 0.5, 1)'; 

                document.body.appendChild(clone);

                requestAnimationFrame(() => {
                    requestAnimationFrame(() => {
                        clone.style.top = (end.top + 10) + 'px'; 
                        clone.style.left = (end.left + 10) + 'px';
                        clone.style.width = '20px'; 
                        clone.style.height = '20px';
                        clone.style.opacity = '0.5'; 
                    });
                });

                setTimeout(() => {
                    clone.remove();
                    cartIcon.classList.remove('animate-rubber-pop');
                    void cartIcon.offsetWidth; 
                    cartIcon.classList.add('animate-rubber-pop');
                    setTimeout(() => cartIcon.classList.remove('animate-rubber-pop'), 600);
                }, 1000); 
            };

            // 3. HELPER TOAST
            window.showToast = function(message) {
                const toast = document.createElement('div');
                toast.className = 'fixed top-24 right-6 bg-green-600 text-white px-6 py-4 rounded-xl shadow-2xl z-[9999] font-bold flex items-center gap-3 animate-fade-in-up transition-opacity duration-500';
                toast.innerHTML = `
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14\"></path><polyline points=\"22 4 12 14.01 9 11.01\"></polyline></svg>
                    <span>${message}</span>
                `;
                document.body.appendChild(toast);
                setTimeout(() => {
                    toast.style.opacity = '0';
                    setTimeout(() => toast.remove(), 500);
                }, 3000);
            };
        });
    </script>
</body>
</html>