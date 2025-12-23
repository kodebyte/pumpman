<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pumpman Shop - The Most Complete Pump & Spare Parts Center</title>
    <meta name="description" content="Shop online for industrial pumps, spare parts, and quality technical equipment. Fast shipping throughout Indonesia.">
    
    <script src="https://cdn.tailwindcss.com"></script>
    
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <script src="https://unpkg.com/lucide@latest"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brand: {
                            dark: '#009a7b',    // SeaGreen (Darker for footer/header)
                            primary: '#009a7b', // SeaGreen (Main Brand Color)
                            soft: '#e8f5e9',    // Very Soft Green (Backgrounds)
                            accent: '#F59E0B',  // Gold/Amber (Highlights/Badges)
                            gray: '#F8FAFC',    // Slate 50 (Page BG)
                            input: '#F1F5F9',   // Slate 100
                        }
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                        display: ['Inter', 'sans-serif'],
                    },
                    boxShadow: {
                        'glow': '0 0 20px rgba(0, 154, 123, 0.5)',
                    }
                }
            }
        }
    </script>
    <style>
        /* Custom Scrollbar */
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: #f1f1f1; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 4px; }
        ::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
        
        /* Glassmorphism Header */
        #sticky-header {
            -webkit-backdrop-filter: blur(12px);
            backdrop-filter: blur(12px);
        }

        /* Hero Animations */
        .slide { transition: opacity 0.8s cubic-bezier(0.4, 0, 0.2, 1); }
        .slide-active { opacity: 1; z-index: 10; }
        .slide-hidden { opacity: 0; z-index: 0; pointer-events: none; }
        
        /* Text Reveal Animation */
        .slide-content > * { opacity: 0; transform: translateY(30px); transition: all 0.8s cubic-bezier(0.4, 0, 0.2, 1); }
        .slide-active .slide-content > *:nth-child(1) { transition-delay: 0.1s; opacity: 1; transform: translateY(0); }
        .slide-active .slide-content > *:nth-child(2) { transition-delay: 0.2s; opacity: 1; transform: translateY(0); }
        .slide-active .slide-content > *:nth-child(3) { transition-delay: 0.3s; opacity: 1; transform: translateY(0); }
        .slide-active .slide-content > *:nth-child(4) { transition-delay: 0.4s; opacity: 1; transform: translateY(0); }

        /* Mega Menu Animation */
        #mega-menu-content { transition: all 0.3s ease-in-out; transform: translateY(10px); opacity: 0; visibility: hidden; }
        #mega-menu-trigger:hover #mega-menu-content, #mega-menu-content:hover { transform: translateY(0); opacity: 1; visibility: visible; }
    </style>
</head>

<body class="font-sans text-slate-700 antialiased bg-brand-gray flex flex-col min-h-screen">

    <div class="bg-brand-dark text-white/90 text-xs py-3 px-4 hidden sm:block font-medium tracking-wide relative z-50">
        <div class="container mx-auto flex justify-between items-center px-4 md:px-6">
            <div class="flex items-center gap-6">
                <div class="flex items-center gap-2"><i data-lucide="check-circle" class="w-3.5 h-3.5 text-white"></i> <span>100% Original Products</span></div>
                <div class="flex items-center gap-2"><i data-lucide="truck" class="w-3.5 h-3.5 text-white"></i> <span>Free Shipping Jabodetabek*</span></div>
            </div>
            <div class="flex items-center gap-6">
                <a href="#" class="hover:text-white transition">Track Order</a>
                <a href="#" class="hover:text-white transition">Help</a>
                <a href="#" class="text-white font-semibold">Login</a>
            </div>
        </div>
    </div>

    <div id="sticky-header" class="sticky top-0 z-40 w-full bg-white/80 backdrop-blur-lg border-b border-white/20 shadow-sm transition-all duration-300 supports-[backdrop-filter]:bg-white/60">
        <div class="border-b border-gray-100/50">
            <div class="container mx-auto px-4 md:px-6">
                <div class="flex justify-between items-center h-20 gap-8">
                    <a href="#" class="flex-shrink-0 flex items-center gap-2">
                        <div class="bg-brand-primary/10 p-2 rounded-lg">
                             <i data-lucide="droplet" class="w-6 h-6 text-brand-primary"></i>
                        </div>
                        <span class="text-2xl font-bold text-brand-primary tracking-tighter">PUMPMAN</span>
                    </a>

                    <div class="hidden md:flex flex-1 max-w-2xl relative group">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <i data-lucide="search" class="h-5 w-5 text-gray-400 group-focus-within:text-brand-primary transition"></i>
                        </div>
                        <input type="text" 
                               class="block w-full pl-11 pr-4 py-3 bg-brand-input border-transparent rounded-full text-sm placeholder-gray-400 focus:bg-white focus:border-brand-primary focus:ring-4 focus:ring-brand-primary/10 transition-all duration-300" 
                               placeholder="Search pumps, spare parts, or item codes...">
                    </div>
                    
                    <div class="flex items-center gap-2 sm:gap-4">
                        <div class="hidden md:flex items-center gap-2 text-xs font-bold border-r border-gray-200 pr-6 mr-2 h-5 text-slate-500">
                            <a href="#" class="text-brand-primary">EN</a>
                            <span class="opacity-30">/</span>
                            <a href="#" class="hover:text-brand-primary transition opacity-50">ID</a>
                        </div>
                        <div class="relative group/user z-50">
                            <button class="relative p-2.5 rounded-full hover:bg-gray-100 transition text-slate-600">
                                <i data-lucide="user" class="w-6 h-6 group-hover/user:text-brand-primary transition"></i>
                            </button>
                            <div class="absolute right-0 top-full pt-2 opacity-0 invisible group-hover/user:opacity-100 group-hover/user:visible transition-all duration-300 transform translate-y-2 group-hover/user:translate-y-0 w-56">
                                <div class="bg-white text-slate-700 shadow-xl rounded-xl border border-gray-100 overflow-hidden p-4">
                                    <p class="text-xs text-gray-500 mb-3 text-center">Login to access your account</p>
                                    <a href="#" class="block w-full bg-slate-900 text-white text-xs font-bold py-2.5 rounded-lg hover:bg-brand-primary transition mb-2 text-center">LOGIN</a>
                                    <a href="#" class="block w-full border border-gray-200 text-slate-700 text-xs font-bold py-2.5 rounded-lg hover:border-slate-900 transition text-center">REGISTER</a>
                                </div>
                            </div>
                        </div>
                        <div class="relative group/cart z-50">
                            <button class="relative p-2.5 rounded-full hover:bg-gray-100 transition text-slate-600">
                                <i data-lucide="shopping-bag" class="w-6 h-6 group-hover/cart:text-brand-primary transition"></i>
                                <span class="absolute top-1 right-1 bg-brand-primary text-white text-[10px] w-4 h-4 rounded-full flex items-center justify-center font-bold shadow-sm">1</span>
                            </button>
                            <div class="absolute right-0 top-full pt-2 opacity-0 invisible group-hover/cart:opacity-100 group-hover/cart:visible transition-all duration-300 transform translate-y-2 group-hover/cart:translate-y-0 w-80 md:w-96">
                                <div class="bg-white text-slate-700 shadow-2xl rounded-xl border border-gray-100 overflow-hidden">
                                    <div class="px-5 py-4 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
                                        <span class="text-sm font-bold text-slate-800">Shopping Cart</span>
                                        <span class="text-xs font-medium text-brand-primary bg-brand-soft px-2 py-1 rounded-full">1 Item</span>
                                    </div>
                                    <div class="max-h-64 overflow-y-auto px-5 py-4 space-y-4 scrollbar-thin">
                                        <div class="flex items-start gap-4 pb-4 border-b border-gray-100 last:border-0 last:pb-0">
                                            <div class="w-16 h-16 bg-gray-50 rounded-lg border border-gray-100 flex-shrink-0 flex items-center justify-center overflow-hidden">
                                                <img src="https://images.unsplash.com/photo-1563823251954-c81b2195dfa6?q=80&w=2072&auto=format&fit=crop" class="w-full h-full object-cover">
                                            </div>
                                            <div class="flex flex-1 flex-col justify-between">
                                                <div>
                                                    <h4 class="text-sm font-bold text-slate-900 line-clamp-1"><a href="#" class="hover:text-brand-primary">Submersible Pro X1</a></h4>
                                                    <p class="text-[10px] text-gray-500 uppercase tracking-wider mt-0.5">Industrial Series</p>
                                                </div>
                                                <div class="flex items-center justify-between mt-2">
                                                    <span class="text-xs text-gray-500">Qty 1</span>
                                                    <span class="text-sm font-bold text-brand-primary">Rp 4.250.000</span>
                                                </div>
                                            </div>
                                            <button class="text-gray-400 hover:text-red-500 transition p-1"><i data-lucide="trash-2" class="w-4 h-4"></i></button>
                                        </div>
                                    </div>
                                    <div class="border-t border-gray-100 bg-gray-50 px-5 py-5">
                                        <div class="flex justify-between text-base font-bold text-slate-900 mb-4">
                                            <p>Subtotal</p>
                                            <p>Rp 4.250.000</p>
                                        </div>
                                        <div class="grid grid-cols-2 gap-3">
                                            <a href="#" class="flex items-center justify-center rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-xs font-bold text-slate-700 shadow-sm hover:bg-gray-50 transition">View Cart</a>
                                            <a href="#" class="flex items-center justify-center rounded-lg border border-transparent bg-brand-primary px-4 py-2.5 text-xs font-bold text-white shadow-sm hover:bg-green-700 transition">Checkout</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button id="mobile-menu-btn" class="md:hidden p-2 text-slate-700 ml-2"><i data-lucide="menu" class="h-7 w-7"></i></button>
                    </div>
                </div>
            </div>
        </div>

        <div class="hidden md:block bg-white/50 relative">
            <div class="container mx-auto px-4 md:px-6">
                <div class="flex h-14 items-center text-sm font-bold tracking-wide text-slate-700">
                    
                    <div id="mega-menu-trigger" class="h-full flex items-center mr-8">
                        <div class="relative group h-full flex items-center cursor-pointer px-3 bg-gray-50 hover:bg-gray-100 rounded-lg transition">
                            <div class="flex items-center gap-2 text-slate-800 font-bold">
                                <i data-lucide="layout-grid" class="w-5 h-5 text-brand-primary"></i>
                                <span class="uppercase">Shop Categories</span>
                                <i data-lucide="chevron-down" class="w-4 h-4 text-gray-400 group-hover:text-brand-primary transition-transform group-hover:rotate-180"></i>
                            </div>
                        </div>
                        <div id="mega-menu-content" class="absolute top-full left-0 w-full bg-white shadow-xl border-t border-gray-100 z-50">
                            <div class="container mx-auto px-8 py-10">
                                <div class="grid grid-cols-12 gap-10">
                                    <div class="col-span-3 border-r border-gray-100 pr-6">
                                        <h3 class="text-xs font-black text-gray-400 uppercase tracking-widest mb-6 flex items-center gap-2"><i data-lucide="list" class="w-4 h-4"></i> Browse Category</h3>
                                        <ul class="space-y-4">
                                            <li><a href="#" class="group/link flex items-center justify-between text-base font-bold text-gray-600 hover:text-brand-primary transition-all"><span>Centrifugal Pumps</span><i data-lucide="chevron-right" class="w-4 h-4 opacity-0 -translate-x-2 group-hover/link:opacity-100 group-hover/link:translate-x-0 transition-all"></i></a></li>
                                            <li><a href="#" class="group/link flex items-center justify-between text-base font-bold text-gray-600 hover:text-brand-primary transition-all"><span>Submersible Pumps</span><i data-lucide="chevron-right" class="w-4 h-4 opacity-0 -translate-x-2 group-hover/link:opacity-100 group-hover/link:translate-x-0 transition-all"></i></a></li>
                                            <li><a href="#" class="group/link flex items-center justify-between text-base font-bold text-gray-600 hover:text-brand-primary transition-all"><span>Dosing Pumps</span><i data-lucide="chevron-right" class="w-4 h-4 opacity-0 -translate-x-2 group-hover/link:opacity-100 group-hover/link:translate-x-0 transition-all"></i></a></li>
                                            <li><a href="#" class="group/link flex items-center justify-between text-base font-bold text-gray-600 hover:text-brand-primary transition-all"><span>Spare Parts</span><i data-lucide="chevron-right" class="w-4 h-4 opacity-0 -translate-x-2 group-hover/link:opacity-100 group-hover/link:translate-x-0 transition-all"></i></a></li>
                                        </ul>
                                        <div class="mt-6 pt-6 border-t border-gray-100">
                                            <a href="#" class="text-sm font-bold text-slate-900 border-b-2 border-black hover:text-brand-primary hover:border-brand-primary transition pb-1 inline-flex items-center gap-2">View All Products <i data-lucide="arrow-right" class="w-4 h-4"></i></a>
                                        </div>
                                    </div>
                                    <div class="col-span-3">
                                        <h3 class="text-xs font-black text-gray-400 uppercase tracking-widest mb-4">New Arrival</h3>
                                        <a href="#" class="group/card block h-full">
                                            <div class="bg-gray-50 rounded-2xl p-6 h-48 flex items-center justify-center relative overflow-hidden mb-4 border border-gray-100 group-hover/card:border-brand-primary/30 transition">
                                                <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-32 h-32 bg-white rounded-full shadow-sm z-0"></div>
                                                <img src="https://images.unsplash.com/photo-1563823251954-c81b2195dfa6?q=80&w=2072&auto=format&fit=crop" class="w-40 max-h-40 object-contain relative z-10 drop-shadow-xl transform group-hover/card:scale-110 transition duration-500" alt="New">
                                                <div class="absolute top-4 left-4 bg-black text-white text-[10px] font-bold px-2 py-1 rounded uppercase tracking-wider">New</div>
                                            </div>
                                            <div><h4 class="text-lg font-bold text-gray-900 group-hover/card:text-brand-primary transition line-clamp-1">Submersible Pro X1</h4><p class="text-sm text-gray-500 mt-1 line-clamp-1">Industrial Series</p></div>
                                        </a>
                                    </div>
                                    <div class="col-span-3">
                                        <h3 class="text-xs font-black text-gray-400 uppercase tracking-widest mb-4">Best Seller</h3>
                                        <a href="#" class="group/card block h-full">
                                            <div class="bg-gray-50 rounded-2xl p-6 h-48 flex items-center justify-center relative overflow-hidden mb-4 border border-gray-100 group-hover/card:border-brand-primary/30 transition">
                                                <img src="https://images.unsplash.com/photo-1574360778004-946766d61665?q=80&w=1974&auto=format&fit=crop" class="w-full h-full object-cover relative z-10 drop-shadow-xl transform group-hover/card:scale-105 transition duration-500 rounded-lg" alt="Best Seller">
                                                <div class="absolute top-4 left-4 bg-brand-primary text-white text-[10px] font-bold px-2 py-1 rounded uppercase tracking-wider">Hot</div>
                                            </div>
                                            <div><h4 class="text-lg font-bold text-gray-900 group-hover/card:text-brand-primary transition line-clamp-1">Centrifugal Heavy Duty</h4><p class="text-sm text-gray-500 mt-1 line-clamp-1">Water Supply</p></div>
                                        </a>
                                    </div>
                                    <div class="col-span-3">
                                        <div class="bg-slate-900 rounded-2xl h-full p-8 flex flex-col justify-between relative overflow-hidden group/banner shadow-lg">
                                            <div class="absolute top-0 right-0 w-48 h-48 bg-brand-primary rounded-full blur-[80px] opacity-30 group-hover/banner:opacity-40 transition duration-700"></div>
                                            <div class="relative z-10">
                                                <span class="bg-white/20 backdrop-blur-md text-white text-[10px] font-bold px-3 py-1 rounded-full mb-4 inline-block border border-white/10">LIMITED OFFER</span>
                                                <h3 class="text-2xl font-black text-white leading-tight mb-2">Year End <br><span class="text-brand-accent">Service Sale</span></h3>
                                                <p class="text-sm text-gray-400 leading-relaxed">Get 30% off for maintenance & spare parts.</p>
                                            </div>
                                            <div class="relative z-10 mt-6"><a href="#" class="bg-white text-black text-xs font-bold px-6 py-3 rounded-full hover:bg-gray-200 transition inline-flex items-center gap-2">Book Now <i data-lucide="arrow-right" class="w-3 h-3"></i></a></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="flex items-center gap-8 text-slate-700">
                        <a href="#" class="hover:text-brand-primary transition uppercase">Home</a>
                        <a href="#" class="hover:text-brand-primary transition uppercase">About Us</a>
                        <a href="#" class="hover:text-brand-primary transition uppercase">Contact Us</a>
                        <a href="#" class="hover:text-brand-primary transition uppercase">Find a Store</a>
                        <div class="relative group h-14 flex items-center">
                            <a href="#" class="hover:text-brand-primary transition uppercase flex items-center gap-1 cursor-pointer">Support <i data-lucide="chevron-down" class="w-4 h-4 transition-transform group-hover:rotate-180"></i></a>
                            <div class="absolute right-0 top-full pt-0 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 transform translate-y-2 group-hover:translate-y-0 min-w-[220px] z-50">
                                <div class="bg-white text-slate-800 shadow-xl rounded-lg border border-gray-100 overflow-hidden py-2 mt-0">
                                    <a href="#" class="flex items-center gap-3 px-6 py-3 text-sm font-bold hover:bg-gray-50 hover:text-brand-primary transition group/item"><i data-lucide="help-circle" class="w-4 h-4 text-gray-400 group-hover/item:text-brand-primary"></i> FAQ</a>
                                    <a href="#" class="flex items-center gap-3 px-6 py-3 text-sm font-bold hover:bg-gray-50 hover:text-brand-primary transition group/item"><i data-lucide="shield-check" class="w-4 h-4 text-gray-400 group-hover/item:text-brand-primary"></i> Warranty Claim</a>
                                    <a href="#" class="flex items-center gap-3 px-6 py-3 text-sm font-bold hover:bg-gray-50 hover:text-brand-primary transition group/item"><i data-lucide="search" class="w-4 h-4 text-gray-400 group-hover/item:text-brand-primary"></i> Claim Status</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <section id="hero-slider" class="relative h-[700px] w-full overflow-hidden bg-brand-dark group/slider">
        <div id="slides-container" class="w-full h-full relative">
            <div class="slide slide-active absolute inset-0 w-full h-full">
                <video class="absolute inset-0 w-full h-full object-cover" autoplay muted loop playsinline poster="https://images.unsplash.com/photo-1565514020125-99c7553f473c?q=80&w=2070&auto=format&fit=crop"><source src="assets/v2.mp4" type="video/mp4"></video>
                <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/50 to-black/30"></div>
                <div class="relative z-10 h-full container mx-auto px-4 md:px-6 flex items-center">
                    <div class="max-w-xl p-8 md:p-0 text-white slide-content">
                        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/20 border border-white/30 text-white text-xs font-bold uppercase tracking-wider mb-6 backdrop-blur-md"><span class="w-2 h-2 rounded-full bg-brand-accent animate-pulse"></span> Official Distributor</div>
                        <h1 class="font-display text-4xl md:text-6xl font-bold leading-tight mb-6">Modern Industrial <br><span class="text-brand-accent">Pump Solutions</span></h1>
                        <p class="text-lg text-gray-100 mb-8 leading-relaxed font-light">Increase your factory efficiency with the latest energy-saving pump technology.</p>
                        <div class="flex gap-4"><a href="#produk" class="bg-brand-accent text-white px-8 py-4 rounded-xl font-bold hover:bg-yellow-500 transition shadow-glow flex items-center gap-2">Shop Now</a></div>
                    </div>
                </div>
            </div>
            <div class="slide slide-hidden absolute inset-0 w-full h-full">
                <div class="absolute inset-0 bg-cover bg-center" style="background-image: url('https://images.unsplash.com/photo-1504917595217-d4dc5ebe6122?q=80&w=2070&auto=format&fit=crop');"></div>
                <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/60 to-transparent"></div>
                <div class="relative z-10 h-full container mx-auto px-4 md:px-6 flex items-center justify-end">
                    <div class="max-w-xl p-8 md:p-0 text-white slide-content">
                        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-blue-500/20 border border-blue-400/30 text-blue-100 text-xs font-bold uppercase tracking-wider mb-6">24/7 Service</div>
                        <h1 class="font-display text-4xl md:text-6xl font-bold leading-tight mb-6">Expert Maintenance <br><span class="text-blue-300">& Repair</span></h1>
                        <p class="text-lg text-gray-100 mb-8 leading-relaxed font-light">Don't let downtime disrupt production. Our certified technician team is ready to help anytime.</p>
                        <div class="flex gap-4"><a href="#" class="bg-blue-600 text-white px-8 py-4 rounded-xl font-bold hover:bg-blue-700 transition shadow-lg">Book Service</a></div>
                    </div>
                </div>
            </div>
        </div>
        <button id="prev-slide" class="absolute left-4 top-1/2 -translate-y-1/2 z-20 p-4 text-white/50 hover:text-white transition-all transform hover:scale-110 focus:outline-none"><i data-lucide="chevron-left" class="w-10 h-10 shadow-sm"></i></button>
        <button id="next-slide" class="absolute right-4 top-1/2 -translate-y-1/2 z-20 p-4 text-white/50 hover:text-white transition-all transform hover:scale-110 focus:outline-none"><i data-lucide="chevron-right" class="w-10 h-10 shadow-sm"></i></button>
        <div id="dots-container" class="absolute bottom-10 left-1/2 -translate-x-1/2 z-20 flex items-center gap-4"></div>
    </section>

    <section class="py-20 bg-white overflow-hidden">
        <div class="container mx-auto px-4 md:px-6">
            <div class="flex justify-between items-end mb-10">
                <div>
                    <span class="text-brand-primary font-bold tracking-widest uppercase text-xs mb-2 block">Browse Collections</span>
                    <h2 class="text-3xl md:text-4xl font-display font-bold text-slate-900">Popular Categories</h2>
                </div>
                
                <div class="flex gap-3">
                    <button id="cat-prev" class="w-10 h-10 rounded-full border border-gray-200 flex items-center justify-center text-slate-600 hover:bg-brand-primary hover:text-white hover:border-brand-primary transition focus:outline-none">
                        <i data-lucide="chevron-left" class="w-5 h-5"></i>
                    </button>
                    <button id="cat-next" class="w-10 h-10 rounded-full border border-gray-200 flex items-center justify-center text-slate-600 hover:bg-brand-primary hover:text-white hover:border-brand-primary transition focus:outline-none">
                        <i data-lucide="chevron-right" class="w-5 h-5"></i>
                    </button>
                </div>
            </div>

            <div id="category-slider" class="flex gap-6 overflow-x-auto no-scrollbar scroll-smooth snap-x snap-mandatory pb-4">
                
                <div class="min-w-[280px] md:min-w-[calc(50%-12px)] lg:min-w-[calc(25%-18px)] flex-shrink-0 snap-start">
                    <a href="#" class="group block bg-white rounded-[2rem] p-6 border border-gray-100 shadow-sm hover:shadow-lg hover:border-brand-primary/30 transition-all duration-300 h-64 relative overflow-hidden">
                        <div class="flex flex-col justify-between h-full relative z-10">
                            <div class="w-14 h-14 rounded-2xl flex items-center justify-center mb-4 transition duration-300 bg-brand-soft text-brand-primary group-hover:scale-110">
                                <i data-lucide="fan" class="w-7 h-7"></i>
                            </div>
                            <div class="mb-2">
                                <h3 class="font-bold text-slate-900 text-xl leading-tight mb-1 group-hover:text-brand-primary transition">Centrifugal Pumps</h3>
                                <p class="text-sm text-slate-500 font-medium">For Water Supply</p>
                            </div>
                        </div>
                        <div class="absolute -right-10 top-1/2 -translate-y-1/2 w-48 h-48 opacity-50 group-hover:scale-110 transition duration-500">
                            <div class="w-full h-full bg-gradient-to-br from-brand-soft to-transparent rounded-full"></div>
                        </div>
                    </a>
                </div>

                <div class="min-w-[280px] md:min-w-[calc(50%-12px)] lg:min-w-[calc(25%-18px)] flex-shrink-0 snap-start">
                    <a href="#" class="group block bg-white rounded-[2rem] p-6 border border-gray-100 shadow-sm hover:shadow-lg hover:border-brand-primary/30 transition-all duration-300 h-64 relative overflow-hidden">
                        <div class="flex flex-col justify-between h-full relative z-10">
                            <div class="w-14 h-14 rounded-2xl flex items-center justify-center mb-4 transition duration-300 bg-blue-50 text-blue-600 group-hover:scale-110">
                                <i data-lucide="droplets" class="w-7 h-7"></i>
                            </div>
                            <div class="mb-2">
                                <h3 class="font-bold text-slate-900 text-xl leading-tight mb-1 group-hover:text-brand-primary transition">Submersible Pumps</h3>
                                <p class="text-sm text-slate-500 font-medium">Deep Well & Drainage</p>
                            </div>
                        </div>
                        <div class="absolute -right-10 top-1/2 -translate-y-1/2 w-48 h-48 opacity-50 group-hover:scale-110 transition duration-500">
                            <div class="w-full h-full bg-gradient-to-br from-blue-50 to-transparent rounded-full"></div>
                        </div>
                    </a>
                </div>

                <div class="min-w-[280px] md:min-w-[calc(50%-12px)] lg:min-w-[calc(25%-18px)] flex-shrink-0 snap-start">
                    <a href="#" class="group block bg-white rounded-[2rem] p-6 border border-gray-100 shadow-sm hover:shadow-lg hover:border-brand-primary/30 transition-all duration-300 h-64 relative overflow-hidden">
                        <div class="flex flex-col justify-between h-full relative z-10">
                            <div class="w-14 h-14 rounded-2xl flex items-center justify-center mb-4 transition duration-300 bg-orange-50 text-orange-600 group-hover:scale-110">
                                <i data-lucide="activity" class="w-7 h-7"></i>
                            </div>
                            <div class="mb-2">
                                <h3 class="font-bold text-slate-900 text-xl leading-tight mb-1 group-hover:text-brand-primary transition">Dosing Pumps</h3>
                                <p class="text-sm text-slate-500 font-medium">Chemical Injection</p>
                            </div>
                        </div>
                        <div class="absolute -right-10 top-1/2 -translate-y-1/2 w-48 h-48 group-hover:scale-110 transition duration-500">
                            <div class="w-full h-full bg-gradient-to-br from-orange-50 to-transparent rounded-full">
                                <img src="p1.png" alt="">
                            </div>
                        </div>
                    </a>
                </div>

                <div class="min-w-[280px] md:min-w-[calc(50%-12px)] lg:min-w-[calc(25%-18px)] flex-shrink-0 snap-start">
                    <a href="#" class="group block bg-white rounded-[2rem] p-6 border border-gray-100 shadow-sm hover:shadow-lg hover:border-brand-primary/30 transition-all duration-300 h-64 relative overflow-hidden">
                        <div class="flex flex-col justify-between h-full relative z-10">
                            <div class="w-14 h-14 rounded-2xl flex items-center justify-center mb-4 transition duration-300 bg-gray-100 text-gray-600 group-hover:scale-110">
                                <i data-lucide="settings" class="w-7 h-7"></i>
                            </div>
                            <div class="mb-2">
                                <h3 class="font-bold text-slate-900 text-xl leading-tight mb-1 group-hover:text-brand-primary transition">Spare Parts</h3>
                                <p class="text-sm text-slate-500 font-medium">Original Components</p>
                            </div>
                        </div>
                        <div class="absolute -right-10 top-1/2 -translate-y-1/2 w-48 h-48 opacity-50 group-hover:scale-110 transition duration-500">
                            <div class="w-full h-full bg-gradient-to-br from-gray-100 to-transparent rounded-full"></div>
                        </div>
                    </a>
                </div>

                <div class="min-w-[280px] md:min-w-[calc(50%-12px)] lg:min-w-[calc(25%-18px)] flex-shrink-0 snap-start">
                    <a href="#" class="group block bg-white rounded-[2rem] p-6 border border-gray-100 shadow-sm hover:shadow-lg hover:border-brand-primary/30 transition-all duration-300 h-64 relative overflow-hidden">
                        <div class="flex flex-col justify-between h-full relative z-10">
                            <div class="w-14 h-14 rounded-2xl flex items-center justify-center mb-4 transition duration-300 bg-purple-50 text-purple-600 group-hover:scale-110">
                                <i data-lucide="cog" class="w-7 h-7"></i>
                            </div>
                            <div class="mb-2">
                                <h3 class="font-bold text-slate-900 text-xl leading-tight mb-1 group-hover:text-brand-primary transition">Gear Pumps</h3>
                                <p class="text-sm text-slate-500 font-medium">Viscous Fluids</p>
                            </div>
                        </div>
                        <div class="absolute -right-10 top-1/2 -translate-y-1/2 w-48 h-48 opacity-50 group-hover:scale-110 transition duration-500">
                            <div class="w-full h-full bg-gradient-to-br from-purple-50 to-transparent rounded-full"></div>
                        </div>
                    </a>
                </div>

                <div class="min-w-[280px] md:min-w-[calc(50%-12px)] lg:min-w-[calc(25%-18px)] flex-shrink-0 snap-start">
                    <a href="#" class="group block bg-white rounded-[2rem] p-6 border border-gray-100 shadow-sm hover:shadow-lg hover:border-brand-primary/30 transition-all duration-300 h-64 relative overflow-hidden">
                        <div class="flex flex-col justify-between h-full relative z-10">
                            <div class="w-14 h-14 rounded-2xl flex items-center justify-center mb-4 transition duration-300 bg-red-50 text-red-600 group-hover:scale-110">
                                <i data-lucide="cpu" class="w-7 h-7"></i>
                            </div>
                            <div class="mb-2">
                                <h3 class="font-bold text-slate-900 text-xl leading-tight mb-1 group-hover:text-brand-primary transition">Control Panels</h3>
                                <p class="text-sm text-slate-500 font-medium">Automation Systems</p>
                            </div>
                        </div>
                        <div class="absolute -right-10 top-1/2 -translate-y-1/2 w-48 h-48 opacity-50 group-hover:scale-110 transition duration-500">
                            <div class="w-full h-full bg-gradient-to-br from-red-50 to-transparent rounded-full"></div>
                        </div>
                    </a>
                </div>

            </div>
        </div>
    </section>

    <section class="py-24 bg-white overflow-hidden relative border-t border-gray-50">
        <div class="absolute top-0 right-0 w-1/3 h-full bg-brand-soft/30 -skew-x-12 translate-x-20 z-0"></div>
        <div class="container mx-auto px-4 md:px-6 relative z-10">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-20 items-center">
                <div class="relative group">
                    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[80%] h-[80%] rounded-full border-2 border-dashed border-brand-primary/20 animate-[spin_20s_linear_infinite]"></div>
                    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[60%] h-[60%] rounded-full bg-brand-soft/50 blur-3xl"></div>
                    <img src="https://images.unsplash.com/photo-1574360778004-946766d61665?q=80&w=1974&auto=format&fit=crop" alt="Industrial Pump" class="relative z-10 w-full h-auto object-contain drop-shadow-2xl hover:scale-105 transition duration-700 mix-blend-multiply">
                    <div class="absolute bottom-10 -right-4 md:right-10 bg-white p-4 rounded-2xl shadow-xl z-20 border border-gray-100 animate-bounce" style="animation-duration: 3s;">
                        <div class="flex items-center gap-3">
                            <div class="bg-green-100 p-2 rounded-full text-green-600"><i data-lucide="zap" class="w-6 h-6"></i></div>
                            <div><p class="text-[10px] text-gray-500 font-bold uppercase">Energy Saving</p><p class="text-lg font-black text-slate-900">Up to 30%</p></div>
                        </div>
                    </div>
                </div>
                <div>
                    <span class="text-brand-primary font-bold tracking-widest uppercase text-xs mb-2 block">Engineering Excellence</span>
                    <h2 class="text-3xl md:text-5xl font-display font-bold text-slate-900 mb-6 leading-tight">Built for <span class="text-brand-primary">Heavy Duty</span> Performance.</h2>
                    <p class="text-slate-500 text-lg mb-10 leading-relaxed">Our pumps are engineered with precision to withstand the toughest industrial environments.</p>
                    <div class="space-y-8">
                        <div class="flex gap-5 group/item">
                            <div class="flex-shrink-0 w-14 h-14 bg-brand-dark text-white rounded-2xl flex items-center justify-center shadow-lg shadow-brand-primary/20 group-hover/item:scale-110 transition duration-300"><i data-lucide="cpu" class="w-7 h-7"></i></div>
                            <div><h4 class="text-xl font-bold text-slate-900 mb-2 group-hover/item:text-brand-primary transition">IE3 High Efficiency Motor</h4><p class="text-sm text-slate-500 leading-relaxed">Equipped with premium copper winding motors that reduce energy consumption.</p></div>
                        </div>
                        <div class="flex gap-5 group/item">
                            <div class="flex-shrink-0 w-14 h-14 bg-white border border-gray-100 text-brand-primary rounded-2xl flex items-center justify-center shadow-md group-hover/item:bg-brand-primary group-hover/item:text-white transition duration-300"><i data-lucide="shield" class="w-7 h-7"></i></div>
                            <div><h4 class="text-xl font-bold text-slate-900 mb-2 group-hover/item:text-brand-primary transition">Anti-Corrosive Coating</h4><p class="text-sm text-slate-500 leading-relaxed">Double-layer electrophoretic coating ensures durability against rust.</p></div>
                        </div>
                    </div>
                    <div class="mt-10 pt-10 border-t border-gray-100">
                        <a href="#" class="inline-flex items-center gap-2 text-sm font-bold text-slate-900 hover:text-brand-primary transition border-b-2 border-black hover:border-brand-primary pb-1">Download Technical Datasheet <i data-lucide="download" class="w-4 h-4"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="py-24 bg-brand-gray overflow-hidden">
        <div class="container mx-auto px-4 md:px-6">
            <div class="flex justify-between items-end mb-10">
               <div><span class="text-brand-primary font-bold tracking-widest uppercase text-xs mb-2 block">Best Choice</span><h2 class="text-3xl md:text-4xl font-display font-bold text-slate-900">Featured Products</h2></div>
               <a href="#" class="group flex items-center gap-2 text-slate-500 hover:text-brand-primary transition font-medium pb-1 border-b border-transparent hover:border-brand-primary">Browse All <i data-lucide="arrow-right" class="w-5 h-5 group-hover:translate-x-1 transition-transform"></i></a>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="group bg-white rounded-[2rem] p-5 border border-gray-100 hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex flex-col h-full relative">
                    <div class="absolute top-5 left-5 z-20 flex flex-col gap-2"><span class="bg-red-500 text-white text-[10px] font-bold px-2 py-1 rounded uppercase tracking-wider">Best Seller</span></div>
                    <a href="#" class="flex-1 w-full flex items-center justify-center mb-6 relative p-4 group-hover:scale-105 transition duration-500"><img src="https://images.unsplash.com/photo-1574360778004-946766d61665?q=80&w=1974&auto=format&fit=crop" class="w-full h-40 object-contain mix-blend-multiply" alt="Product"></a>
                    <div class="mt-auto">
                        <div class="mb-4"><p class="text-slate-400 text-[10px] font-bold uppercase tracking-wider mb-1">Centrifugal Series</p><h3 class="font-bold text-slate-900 text-lg leading-tight group-hover:text-brand-primary transition"><a href="#">Industrial Pump X5</a></h3></div>
                        <div class="flex items-center justify-between border-t border-gray-50 pt-4 gap-2">
                            <div class="flex flex-col"><span class="text-[10px] text-gray-400 line-through">Rp 14.000.000</span><span class="text-slate-900 font-bold text-sm">Rp 12.500.000</span></div>
                            <div class="flex items-center gap-4">
                                <a href="#" class="relative text-xs font-bold text-slate-500 hover:text-brand-primary transition-colors py-1 after:absolute after:bottom-0 after:left-0 after:h-[2px] after:w-0 after:bg-brand-primary hover:after:w-full after:transition-all after:duration-300">Detail</a>
                                <button class="bg-brand-primary text-white px-4 py-2 rounded-full font-bold text-xs hover:bg-brand-dark transition shadow-lg flex items-center gap-1.5 transform active:scale-95">Buy <i data-lucide="shopping-cart" class="w-3.5 h-3.5"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="group bg-white rounded-[2rem] p-5 border border-gray-100 hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex flex-col h-full relative">
                    <div class="absolute top-5 left-5 z-20 flex flex-col gap-2"><span class="bg-brand-accent text-brand-dark text-[10px] font-bold px-2 py-1 rounded uppercase tracking-wider">New</span></div>
                    <a href="#" class="flex-1 w-full flex items-center justify-center mb-6 relative p-4 group-hover:scale-105 transition duration-500"><img src="https://images.unsplash.com/photo-1563823251954-c81b2195dfa6?q=80&w=2072&auto=format&fit=crop" class="w-full h-40 object-contain mix-blend-multiply" alt="Product"></a>
                    <div class="mt-auto">
                        <div class="mb-4"><p class="text-slate-400 text-[10px] font-bold uppercase tracking-wider mb-1">Deep Well Series</p><h3 class="font-bold text-slate-900 text-lg leading-tight group-hover:text-brand-primary transition"><a href="#">Submersible Pro 200</a></h3></div>
                        <div class="flex items-center justify-between border-t border-gray-50 pt-4 gap-2">
                            <div class="flex flex-col"><span class="text-slate-900 font-bold text-sm">Rp 8.200.000</span></div>
                            <div class="flex items-center gap-4">
                                <a href="#" class="relative text-xs font-bold text-slate-500 hover:text-brand-primary transition-colors py-1 after:absolute after:bottom-0 after:left-0 after:h-[2px] after:w-0 after:bg-brand-primary hover:after:w-full after:transition-all after:duration-300">Detail</a>
                                <button class="bg-brand-primary text-white px-4 py-2 rounded-full font-bold text-xs hover:bg-brand-dark transition shadow-lg flex items-center gap-1.5 transform active:scale-95">Buy <i data-lucide="shopping-cart" class="w-3.5 h-3.5"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="group bg-white rounded-[2rem] p-5 border border-gray-100 hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex flex-col h-full relative">
                    <a href="#" class="flex-1 w-full flex items-center justify-center mb-6 relative p-4 group-hover:scale-105 transition duration-500"><img src="https://plus.unsplash.com/premium_photo-1664302152990-238497673552?q=80&w=1974&auto=format&fit=crop" class="w-full h-40 object-contain mix-blend-multiply" alt="Product"></a>
                    <div class="mt-auto">
                        <div class="mb-4"><p class="text-slate-400 text-[10px] font-bold uppercase tracking-wider mb-1">Chemical Series</p><h3 class="font-bold text-slate-900 text-lg leading-tight group-hover:text-brand-primary transition"><a href="#">Dosing Pump A1</a></h3></div>
                        <div class="flex items-center justify-between border-t border-gray-50 pt-4 gap-2">
                            <div class="flex flex-col"><span class="text-slate-900 font-bold text-sm">Rp 4.750.000</span></div>
                            <div class="flex items-center gap-4">
                                <a href="#" class="relative text-xs font-bold text-slate-500 hover:text-brand-primary transition-colors py-1 after:absolute after:bottom-0 after:left-0 after:h-[2px] after:w-0 after:bg-brand-primary hover:after:w-full after:transition-all after:duration-300">Detail</a>
                                <button class="bg-brand-primary text-white px-4 py-2 rounded-full font-bold text-xs hover:bg-brand-dark transition shadow-lg flex items-center gap-1.5 transform active:scale-95">Buy <i data-lucide="shopping-cart" class="w-3.5 h-3.5"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="group bg-white rounded-[2rem] p-5 border border-gray-100 hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex flex-col h-full relative">
                    <div class="absolute top-5 left-5 z-20 flex flex-col gap-2"><span class="bg-green-100 text-green-700 text-[10px] font-bold px-2 py-1 rounded uppercase tracking-wider">Promo</span></div>
                    <a href="#" class="flex-1 w-full flex items-center justify-center mb-6 relative p-4 group-hover:scale-105 transition duration-500"><div class="w-32 h-32 bg-gray-50 rounded-full flex items-center justify-center"><i data-lucide="image" class="w-10 h-10 text-gray-300"></i></div></a>
                    <div class="mt-auto">
                        <div class="mb-4"><p class="text-slate-400 text-[10px] font-bold uppercase tracking-wider mb-1">High Pressure</p><h3 class="font-bold text-slate-900 text-lg leading-tight group-hover:text-brand-primary transition"><a href="#">Vertical Multistage</a></h3></div>
                        <div class="flex items-center justify-between border-t border-gray-50 pt-4 gap-2">
                            <div class="flex flex-col"><span class="text-slate-900 font-bold text-sm">Rp 15.000.000</span></div>
                            <div class="flex items-center gap-4">
                                <a href="#" class="relative text-xs font-bold text-slate-500 hover:text-brand-primary transition-colors py-1 after:absolute after:bottom-0 after:left-0 after:h-[2px] after:w-0 after:bg-brand-primary hover:after:w-full after:transition-all after:duration-300">Detail</a>
                                <button class="bg-brand-primary text-white px-4 py-2 rounded-full font-bold text-xs hover:bg-brand-dark transition shadow-lg flex items-center gap-1.5 transform active:scale-95">Buy <i data-lucide="shopping-cart" class="w-3.5 h-3.5"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="py-12 border-t border-gray-50 bg-white">
        <div class="container mx-auto px-4 md:px-6">
            <p class="text-center text-sm font-bold text-gray-400 uppercase tracking-widest mb-8">Trusted by 500+ Industries & Companies</p>
            <div class="flex flex-wrap justify-center gap-8 md:gap-16 opacity-60 grayscale hover:grayscale-0 transition-all duration-500">
                <div class="flex items-center gap-2 group cursor-default">
                    <div class="p-2 bg-gray-100 rounded-lg group-hover:bg-blue-50 transition"><i data-lucide="building-2" class="w-8 h-8 text-slate-400 group-hover:text-blue-600"></i></div>
                    <span class="font-black text-xl text-slate-300 group-hover:text-slate-600">PDAM JAYA</span>
                </div>
                <div class="flex items-center gap-2 group cursor-default">
                    <div class="p-2 bg-gray-100 rounded-lg group-hover:bg-orange-50 transition"><i data-lucide="factory" class="w-8 h-8 text-slate-400 group-hover:text-orange-600"></i></div>
                    <span class="font-black text-xl text-slate-300 group-hover:text-slate-600">INDOFOOD</span>
                </div>
                <div class="flex items-center gap-2 group cursor-default">
                    <div class="p-2 bg-gray-100 rounded-lg group-hover:bg-red-50 transition"><i data-lucide="hard-hat" class="w-8 h-8 text-slate-400 group-hover:text-red-600"></i></div>
                    <span class="font-black text-xl text-slate-300 group-hover:text-slate-600">WIKA KARYA</span>
                </div>
                <div class="flex items-center gap-2 group cursor-default">
                    <div class="p-2 bg-gray-100 rounded-lg group-hover:bg-green-50 transition"><i data-lucide="droplets" class="w-8 h-8 text-slate-400 group-hover:text-green-600"></i></div>
                    <span class="font-black text-xl text-slate-300 group-hover:text-slate-600">UNILEVER</span>
                </div>
                 <div class="flex items-center gap-2 group cursor-default">
                    <div class="p-2 bg-gray-100 rounded-lg group-hover:bg-purple-50 transition"><i data-lucide="hotel" class="w-8 h-8 text-slate-400 group-hover:text-purple-600"></i></div>
                    <span class="font-black text-xl text-slate-300 group-hover:text-slate-600">ASTON HOTEL</span>
                </div>
            </div>
        </div>
    </section>

    <section class="py-10 bg-white">
        <div class="container mx-auto px-4 md:px-6">
            <div class="bg-brand-dark rounded-[2.5rem] p-8 md:p-12 relative overflow-hidden shadow-2xl flex flex-col md:flex-row items-center justify-between gap-8 group">
                <div class="absolute top-0 right-0 w-64 h-64 bg-white/5 rounded-full blur-3xl -translate-y-1/2 translate-x-1/2"></div>
                <div class="absolute bottom-0 left-0 w-48 h-48 bg-brand-accent/20 rounded-full blur-2xl translate-y-1/2 -translate-x-1/2"></div>
                <div class="absolute inset-0 opacity-10" style="background-image: radial-gradient(#ffffff 1px, transparent 1px); background-size: 20px 20px;"></div>
                <div class="relative z-10 max-w-2xl text-center md:text-left">
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/10 border border-white/20 text-brand-accent text-xs font-bold uppercase tracking-wider mb-4">
                        <span class="w-2 h-2 rounded-full bg-brand-accent animate-pulse"></span> Online Support
                    </div>
                    <h2 class="text-3xl md:text-4xl font-display font-bold text-white mb-4 leading-tight">Confused about calculating <br><span class="text-brand-accent">Head & Flow?</span></h2>
                    <p class="text-white/80 text-lg font-light leading-relaxed">Don't risk buying the wrong pump. Our certified engineers are ready to help you calculate the specifications for free.</p>
                </div>
                <div class="relative z-10 flex flex-col sm:flex-row gap-4">
                    <a href="#" class="bg-white text-brand-dark px-8 py-4 rounded-full font-bold hover:bg-gray-100 transition shadow-lg flex items-center justify-center gap-2 group/btn"><i data-lucide="message-circle" class="w-5 h-5"></i> Chat via WhatsApp</a>
                    <a href="#" class="px-8 py-4 rounded-full font-bold text-white border border-white/30 hover:bg-white/10 transition flex items-center justify-center gap-2"><i data-lucide="phone" class="w-5 h-5"></i> Call Sales</a>
                </div>
            </div>
        </div>
    </section>

    <section class="py-24 bg-white">
        <div class="container mx-auto px-4 md:px-6">
            <div class="flex justify-between items-end mb-12">
               <div><span class="text-brand-primary font-bold tracking-widest uppercase text-xs mb-2 block">Industry Insights</span><h2 class="text-3xl md:text-4xl font-display font-bold text-slate-900">Latest News</h2></div>
               <a href="#" class="group flex items-center gap-2 text-slate-500 hover:text-brand-primary transition font-medium pb-1 border-b border-transparent hover:border-brand-primary">Read Blog <i data-lucide="arrow-right" class="w-5 h-5 group-hover:translate-x-1 transition-transform"></i></a>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
               <article class="group cursor-pointer flex flex-col h-full">
                   <div class="overflow-hidden rounded-[2rem] relative mb-5 aspect-[4/3]">
                       <img src="https://images.unsplash.com/photo-1504328345606-18bbc8c9d7d1?q=80&w=2070&auto=format&fit=crop" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110" alt="News">
                       <div class="absolute top-4 left-4 bg-white/90 backdrop-blur-md px-4 py-2 rounded-xl shadow-sm"><span class="block text-xs font-bold text-slate-400 uppercase tracking-wider">Oct</span><span class="block text-xl font-black text-slate-900 leading-none text-center">12</span></div>
                   </div>
                   <div class="flex flex-col flex-1">
                       <div class="flex items-center gap-2 text-brand-primary text-xs font-bold uppercase tracking-widest mb-2"><i data-lucide="tag" class="w-3 h-3"></i> Maintenance</div>
                       <h3 class="text-2xl font-bold text-slate-900 leading-snug mb-4 group-hover:text-brand-primary transition-colors">Centrifugal Pump Maintenance for Longevity</h3>
                       <div class="mt-auto"><span class="inline-flex items-center gap-2 text-sm font-bold text-slate-900 group-hover:text-brand-primary transition border-b-2 border-transparent group-hover:border-brand-primary pb-0.5">Read Article <i data-lucide="arrow-up-right" class="w-4 h-4"></i></span></div>
                   </div>
               </article>
               <article class="group cursor-pointer flex flex-col h-full">
                   <div class="overflow-hidden rounded-[2rem] relative mb-5 aspect-[4/3]">
                       <img src="https://plus.unsplash.com/premium_photo-1661963874418-d111a1e1245d?q=80&w=2070&auto=format&fit=crop" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110" alt="News">
                       <div class="absolute top-4 left-4 bg-white/90 backdrop-blur-md px-4 py-2 rounded-xl shadow-sm"><span class="block text-xs font-bold text-slate-400 uppercase tracking-wider">Sep</span><span class="block text-xl font-black text-slate-900 leading-none text-center">28</span></div>
                   </div>
                   <div class="flex flex-col flex-1">
                       <div class="flex items-center gap-2 text-brand-primary text-xs font-bold uppercase tracking-widest mb-2"><i data-lucide="tag" class="w-3 h-3"></i> Technology</div>
                       <h3 class="text-2xl font-bold text-slate-900 leading-snug mb-4 group-hover:text-brand-primary transition-colors">New Smart Sensors for Dosing Pumps</h3>
                       <div class="mt-auto"><span class="inline-flex items-center gap-2 text-sm font-bold text-slate-900 group-hover:text-brand-primary transition border-b-2 border-transparent group-hover:border-brand-primary pb-0.5">Read Article <i data-lucide="arrow-up-right" class="w-4 h-4"></i></span></div>
                   </div>
               </article>
               <article class="group cursor-pointer flex flex-col h-full">
                   <div class="overflow-hidden rounded-[2rem] relative mb-5 aspect-[4/3]">
                       <img src="https://images.unsplash.com/photo-1581091226825-a6a2a5aee158?q=80&w=2070&auto=format&fit=crop" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110" alt="News">
                       <div class="absolute top-4 left-4 bg-white/90 backdrop-blur-md px-4 py-2 rounded-xl shadow-sm"><span class="block text-xs font-bold text-slate-400 uppercase tracking-wider">Aug</span><span class="block text-xl font-black text-slate-900 leading-none text-center">15</span></div>
                   </div>
                   <div class="flex flex-col flex-1">
                       <div class="flex items-center gap-2 text-brand-primary text-xs font-bold uppercase tracking-widest mb-2"><i data-lucide="tag" class="w-3 h-3"></i> Company</div>
                       <h3 class="text-2xl font-bold text-slate-900 leading-snug mb-4 group-hover:text-brand-primary transition-colors">Pumpman Wins "Best Industrial Supplier 2024"</h3>
                       <div class="mt-auto"><span class="inline-flex items-center gap-2 text-sm font-bold text-slate-900 group-hover:text-brand-primary transition border-b-2 border-transparent group-hover:border-brand-primary pb-0.5">Read Article <i data-lucide="arrow-up-right" class="w-4 h-4"></i></span></div>
                   </div>
               </article>
            </div>
        </div>
    </section>

    <section class="py-24 bg-brand-gray overflow-hidden">
        <div class="container mx-auto px-4 md:px-6">
            <div class="flex justify-between items-end mb-10">
               <div><span class="text-brand-primary font-bold tracking-widest uppercase text-xs mb-2 block">Our Credibility</span><h2 class="text-3xl md:text-4xl font-display font-bold text-slate-900">Certifications & Awards</h2></div>
               <div class="flex gap-3">
                  <button id="cert-prev" class="w-10 h-10 rounded-full border border-gray-200 bg-white flex items-center justify-center text-slate-600 hover:bg-brand-primary hover:text-white hover:border-brand-primary transition focus:outline-none shadow-sm"><i data-lucide="chevron-left" class="w-5 h-5"></i></button>
                  <button id="cert-next" class="w-10 h-10 rounded-full border border-gray-200 bg-white flex items-center justify-center text-slate-600 hover:bg-brand-primary hover:text-white hover:border-brand-primary transition focus:outline-none shadow-sm"><i data-lucide="chevron-right" class="w-5 h-5"></i></button>
               </div>
            </div>
            <div id="certification-slider" class="flex gap-6 overflow-x-auto no-scrollbar scroll-smooth snap-x snap-mandatory pb-4">
                 <div class="min-w-[280px] md:min-w-[320px] bg-white rounded-[2rem] p-8 border border-gray-100 shadow-sm hover:shadow-lg hover:border-brand-primary/30 transition-all duration-300 flex flex-col items-center text-center snap-start group cursor-default">
                     <div class="w-20 h-20 bg-brand-soft rounded-2xl flex items-center justify-center mb-6 transition duration-300 group-hover:scale-110"><i data-lucide="award" class="w-10 h-10 text-brand-primary"></i></div>
                     <h3 class="font-bold text-slate-900 text-xl mb-2 group-hover:text-brand-primary transition">ISO 9001:2015</h3><p class="text-sm text-slate-500 leading-relaxed">Certified Quality Management System.</p>
                 </div>
                 <div class="min-w-[280px] md:min-w-[320px] bg-white rounded-[2rem] p-8 border border-gray-100 shadow-sm hover:shadow-lg hover:border-brand-primary/30 transition-all duration-300 flex flex-col items-center text-center snap-start group cursor-default">
                     <div class="w-20 h-20 bg-blue-50 rounded-2xl flex items-center justify-center mb-6 transition duration-300 group-hover:scale-110"><i data-lucide="shield-check" class="w-10 h-10 text-blue-600"></i></div>
                     <h3 class="font-bold text-slate-900 text-xl mb-2 group-hover:text-brand-primary transition">SNI Certified</h3><p class="text-sm text-slate-500 leading-relaxed">Meets Indonesian National Standard.</p>
                 </div>
                 <div class="min-w-[280px] md:min-w-[320px] bg-white rounded-[2rem] p-8 border border-gray-100 shadow-sm hover:shadow-lg hover:border-brand-primary/30 transition-all duration-300 flex flex-col items-center text-center snap-start group cursor-default">
                     <div class="w-20 h-20 bg-red-50 rounded-2xl flex items-center justify-center mb-6 transition duration-300 group-hover:scale-110"><i data-lucide="flag" class="w-10 h-10 text-red-600"></i></div>
                     <h3 class="font-bold text-slate-900 text-xl mb-2 group-hover:text-brand-primary transition">TKDN > 40%</h3><p class="text-sm text-slate-500 leading-relaxed">High local content certification.</p>
                 </div>
                 <div class="min-w-[280px] md:min-w-[320px] bg-white rounded-[2rem] p-8 border border-gray-100 shadow-sm hover:shadow-lg hover:border-brand-primary/30 transition-all duration-300 flex flex-col items-center text-center snap-start group cursor-default">
                     <div class="w-20 h-20 bg-green-50 rounded-2xl flex items-center justify-center mb-6 transition duration-300 group-hover:scale-110"><i data-lucide="leaf" class="w-10 h-10 text-green-600"></i></div>
                     <h3 class="font-bold text-slate-900 text-xl mb-2 group-hover:text-brand-primary transition">Green Industry</h3><p class="text-sm text-slate-500 leading-relaxed">Eco-friendly operational standards.</p>
                 </div>
            </div>
        </div>
    </section>

    <div class="bg-white">
        <section class="py-20 border-b border-gray-100">
            <div class="container mx-auto px-4 md:px-6 text-center">
                <div class="max-w-2xl mx-auto">
                    <span class="text-brand-primary font-bold tracking-widest uppercase text-xs mb-3 block">Stay Connected</span>
                    <h2 class="text-3xl md:text-4xl font-display font-bold text-slate-900 mb-4">Don't Miss Special Promos</h2>
                    <p class="text-slate-500 mb-10 text-lg font-light">Get the latest product info and exclusive discounts directly to your email.</p>
                    <form class="relative max-w-lg mx-auto flex items-center group">
                        <i data-lucide="mail" class="absolute left-6 w-5 h-5 text-gray-400 group-focus-within:text-brand-primary transition-colors"></i>
                        <input type="email" placeholder="Enter your email address" class="w-full pl-14 pr-36 py-4 rounded-full border border-gray-200 bg-gray-50 focus:bg-white focus:ring-4 focus:ring-brand-primary/10 focus:border-brand-primary outline-none transition-all shadow-sm text-sm font-medium placeholder-gray-400">
                        <button class="absolute right-2 top-2 bottom-2 bg-slate-900 text-white px-6 rounded-full font-bold hover:bg-brand-primary transition-colors shadow-md text-xs sm:text-sm">Subscribe</button>
                    </form>
                    <p class="text-[10px] text-gray-400 mt-4">We respect your privacy. No spam, ever.</p>
                </div>
            </div>
        </section>
        <section class="py-12 bg-white">
            <div class="container mx-auto px-4 md:px-6">
                <div class="grid grid-cols-2 md:grid-cols-4 gap-8 md:gap-4 divide-x-0 md:divide-x divide-gray-100">
                    <div class="flex items-center justify-center gap-4 px-2">
                        <div class="w-12 h-12 bg-brand-soft rounded-full flex items-center justify-center text-brand-primary flex-shrink-0"><i data-lucide="truck" class="w-6 h-6"></i></div>
                        <div><h4 class="font-bold text-slate-900 text-sm md:text-base leading-tight">Fast Delivery</h4><p class="text-[10px] md:text-xs text-slate-500 mt-0.5">24h Jabodetabek*</p></div>
                    </div>
                    <div class="flex items-center justify-center gap-4 px-2">
                        <div class="w-12 h-12 bg-brand-soft rounded-full flex items-center justify-center text-brand-primary flex-shrink-0"><i data-lucide="shield-check" class="w-6 h-6"></i></div>
                        <div><h4 class="font-bold text-slate-900 text-sm md:text-base leading-tight">Official Warranty</h4><p class="text-[10px] md:text-xs text-slate-500 mt-0.5">100% Original</p></div>
                    </div>
                    <div class="flex items-center justify-center gap-4 px-2">
                        <div class="w-12 h-12 bg-brand-soft rounded-full flex items-center justify-center text-brand-primary flex-shrink-0"><i data-lucide="headphones" class="w-6 h-6"></i></div>
                        <div><h4 class="font-bold text-slate-900 text-sm md:text-base leading-tight">24/7 Support</h4><p class="text-[10px] md:text-xs text-slate-500 mt-0.5">Expert Consultation</p></div>
                    </div>
                    <div class="flex items-center justify-center gap-4 px-2">
                        <div class="w-12 h-12 bg-brand-soft rounded-full flex items-center justify-center text-brand-primary flex-shrink-0"><i data-lucide="credit-card" class="w-6 h-6"></i></div>
                        <div><h4 class="font-bold text-slate-900 text-sm md:text-base leading-tight">Secure Payment</h4><p class="text-[10px] md:text-xs text-slate-500 mt-0.5">100% Safe Transaction</p></div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <footer class="bg-brand-dark text-white pt-16 pb-8 mt-auto border-t border-white/10">
        <div class="container mx-auto px-4 md:px-6">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12 mb-16">
                <div>
                    <div class="flex items-center gap-2 mb-6">
                        <div class="bg-white/10 p-2 rounded-lg backdrop-blur-sm"><i data-lucide="droplet" class="w-6 h-6 text-white"></i></div>
                        <span class="font-display font-bold text-2xl tracking-tight">PUMPMAN</span>
                    </div>
                    <p class="text-white/80 text-sm leading-relaxed mb-8">The most complete industrial pump and spare parts center in Indonesia. We provide authentic products with official warranty and expert support.</p>
                    <div class="flex gap-4">
                        <a href="#" class="w-10 h-10 rounded-full bg-white/10 flex items-center justify-center hover:bg-white hover:text-brand-dark transition-all duration-300"><i data-lucide="facebook" class="w-5 h-5"></i></a>
                        <a href="#" class="w-10 h-10 rounded-full bg-white/10 flex items-center justify-center hover:bg-white hover:text-brand-dark transition-all duration-300"><i data-lucide="instagram" class="w-5 h-5"></i></a>
                        <a href="#" class="w-10 h-10 rounded-full bg-white/10 flex items-center justify-center hover:bg-white hover:text-brand-dark transition-all duration-300"><i data-lucide="linkedin" class="w-5 h-5"></i></a>
                    </div>
                </div>
                <div>
                   <h4 class="font-bold text-lg mb-6 flex items-center gap-2">Explore <span class="w-8 h-0.5 bg-brand-accent/50 rounded-full"></span></h4>
                   <ul class="space-y-4 text-sm text-white/80">
                      <li><a href="#" class="hover:text-brand-accent hover:pl-2 transition-all duration-300 inline-block">Home</a></li>
                      <li><a href="#" class="hover:text-brand-accent hover:pl-2 transition-all duration-300 inline-block">All Products</a></li>
                      <li><a href="#" class="hover:text-brand-accent hover:pl-2 transition-all duration-300 inline-block">About Us</a></li>
                      <li><a href="#" class="hover:text-brand-accent hover:pl-2 transition-all duration-300 inline-block">Latest News</a></li>
                      <li><a href="#" class="hover:text-brand-accent hover:pl-2 transition-all duration-300 inline-block">Contact Support</a></li>
                   </ul>
                </div>
                <div>
                   <h4 class="font-bold text-lg mb-6 flex items-center gap-2">Official Stores <span class="w-8 h-0.5 bg-brand-accent/50 rounded-full"></span></h4>
                   <ul class="space-y-3">
                      <li>
                          <a href="#" class="group flex items-center gap-3 bg-white/5 hover:bg-white/10 border border-white/10 px-3 py-3 rounded-xl transition-all">
                              <div class="bg-white rounded-lg w-8 h-8 flex items-center justify-center p-1 shadow-sm flex-shrink-0"><img src="https://assets.tokopedia.net/assets-tokopedia-lite/v2/zeus/kratos/6055eb63.svg" alt="Tokopedia" class="w-full h-full object-contain"></div>
                              <div class="flex-1"><span class="block text-white font-bold leading-none">Tokopedia</span><span class="text-[10px] text-white/50 group-hover:text-brand-accent transition-colors">Official Store</span></div>
                              <i data-lucide="external-link" class="w-4 h-4 text-white/30 group-hover:text-white ml-auto"></i>
                          </a>
                      </li>
                      <li>
                          <a href="#" class="group flex items-center gap-3 bg-white/5 hover:bg-white/10 border border-white/10 px-3 py-3 rounded-xl transition-all">
                              <div class="bg-white rounded-lg w-8 h-8 flex items-center justify-center p-1 shadow-sm flex-shrink-0"><img src="https://upload.wikimedia.org/wikipedia/commons/f/fe/Shopee.svg" alt="Shopee" class="w-full h-full object-contain"></div>
                              <div class="flex-1"><span class="block text-white font-bold leading-none">Shopee</span><span class="text-[10px] text-white/50 group-hover:text-brand-accent transition-colors">Shopee Mall</span></div>
                              <i data-lucide="external-link" class="w-4 h-4 text-white/30 group-hover:text-white ml-auto"></i>
                          </a>
                      </li>
                   </ul>
                </div>
                <div>
                   <h4 class="font-bold text-lg mb-6 flex items-center gap-2">We Accept <span class="w-8 h-0.5 bg-brand-accent/50 rounded-full"></span></h4>
                   <p class="text-white/70 text-sm mb-4">Secure payments via trusted partners:</p>
                   <div class="grid grid-cols-4 gap-2">
                       <div class="bg-white rounded-md h-9 p-1 flex items-center justify-center shadow-sm hover:scale-105 transition overflow-hidden"><img src="https://upload.wikimedia.org/wikipedia/commons/5/5c/Bank_Central_Asia.svg" alt="BCA" class="h-full object-contain"></div>
                       <div class="bg-white rounded-md h-9 p-1 flex items-center justify-center shadow-sm hover:scale-105 transition overflow-hidden"><img src="https://upload.wikimedia.org/wikipedia/commons/a/ad/Bank_Mandiri_logo_2016.svg" alt="Mandiri" class="h-full object-contain"></div>
                       <div class="bg-white rounded-md h-9 p-1 flex items-center justify-center shadow-sm hover:scale-105 transition overflow-hidden"><img src="https://upload.wikimedia.org/wikipedia/id/5/55/BNI_logo.svg" alt="BNI" class="h-full object-contain"></div>
                       <div class="bg-white rounded-md h-9 p-1 flex items-center justify-center shadow-sm hover:scale-105 transition overflow-hidden"><img src="https://upload.wikimedia.org/wikipedia/commons/6/68/BANK_BRI_logo.svg" alt="BRI" class="h-full object-contain"></div>
                       <div class="bg-white rounded-md h-9 p-1 flex items-center justify-center shadow-sm hover:scale-105 transition overflow-hidden"><img src="https://upload.wikimedia.org/wikipedia/commons/5/5e/Visa_Inc._logo.svg" alt="Visa" class="h-full object-contain"></div>
                       <div class="bg-white rounded-md h-9 p-1 flex items-center justify-center shadow-sm hover:scale-105 transition overflow-hidden"><img src="https://upload.wikimedia.org/wikipedia/commons/2/2a/Mastercard-logo.svg" alt="MasterCard" class="h-full object-contain"></div>
                       <div class="col-span-2 bg-white rounded-md h-9 p-1 flex items-center justify-center shadow-sm hover:scale-105 transition overflow-hidden"><img src="https://upload.wikimedia.org/wikipedia/commons/a/a2/Logo_QRIS.svg" alt="QRIS" class="h-full object-contain"></div>
                   </div>
                   <div class="mt-6 flex items-center gap-2 text-xs text-white/50 bg-white/5 p-3 rounded-lg border border-white/5">
                       <i data-lucide="lock" class="w-4 h-4 text-brand-accent"></i>
                       <span>Encrypted & Secure Transaction</span>
                   </div>
                </div>
            </div>
            <div class="pt-8 border-t border-white/10 flex flex-col md:flex-row justify-between items-center gap-4 text-xs text-white/60">
                <p>&copy; 2024 PT. Pumpman Indonesia Industry. All rights reserved.</p>
                <div class="flex gap-6"><a href="#" class="hover:text-white transition">Privacy Policy</a><a href="#" class="hover:text-white transition">Terms of Service</a><a href="#" class="hover:text-white transition">Sitemap</a></div>
            </div>
        </div>
    </footer>

    <div x-data="{ isOpen: false }" 
        class="fixed bottom-6 right-6 z-[9999] font-sans group">
        
        <div x-show="isOpen"
            x-transition:enter="transition ease-out duration-300 transform origin-bottom-right"
            x-transition:enter-start="opacity-0 scale-90 translate-y-2"
            x-transition:enter-end="opacity-100 scale-100 translate-y-0"
            x-transition:leave="transition ease-in duration-200 transform origin-bottom-right"
            x-transition:leave-start="opacity-100 scale-100 translate-y-0"
            x-transition:leave-end="opacity-0 scale-90 translate-y-2"
            @click.outside="isOpen = false"
            class="absolute bottom-20 right-0 w-[300px] bg-white rounded-2xl shadow-2xl border border-gray-100 overflow-hidden">
            
            <div class="bg-brand-dark p-5 relative overflow-hidden">
                <div class="absolute top-0 right-0 w-24 h-24 bg-white/10 rounded-full -translate-y-1/2 translate-x-1/2"></div>
                <h3 class="text-white font-bold text-lg relative z-10">Hello, Pumpman here! 👋</h3>
                <p class="text-white/80 text-xs mt-1 relative z-10">Need help with pumps? Chat with our team below.</p>
            </div>

            <div class="p-4 space-y-3">
                
                <a href="https://wa.me/6281234567890?text=Halo%20Sales%20Pumpman" target="_blank" class="flex items-center gap-4 p-3 rounded-xl hover:bg-brand-soft/50 transition-colors group/item">
                    <div class="relative">
                        <div class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center text-green-600">
                            <i data-lucide="shopping-bag" class="w-5 h-5"></i>
                        </div>
                        <div class="absolute bottom-0 right-0 w-3 h-3 bg-green-500 border-2 border-white rounded-full"></div>
                    </div>
                    <div>
                        <h4 class="font-bold text-slate-800 text-sm group-hover/item:text-brand-primary transition">Sales Support</h4>
                        <p class="text-xs text-slate-500">Order & Price Inquiry</p>
                    </div>
                    <i data-lucide="chevron-right" class="w-4 h-4 text-slate-300 ml-auto group-hover/item:text-brand-primary"></i>
                </a>

                <a href="https://wa.me/6281234567891?text=Halo%20Engineer%20Pumpman" target="_blank" class="flex items-center gap-4 p-3 rounded-xl hover:bg-brand-soft/50 transition-colors group/item">
                    <div class="relative">
                        <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-600">
                            <i data-lucide="wrench" class="w-5 h-5"></i>
                        </div>
                        <div class="absolute bottom-0 right-0 w-3 h-3 bg-green-500 border-2 border-white rounded-full"></div>
                    </div>
                    <div>
                        <h4 class="font-bold text-slate-800 text-sm group-hover/item:text-brand-primary transition">Technical Engineer</h4>
                        <p class="text-xs text-slate-500">Spec Calculation</p>
                    </div>
                    <i data-lucide="chevron-right" class="w-4 h-4 text-slate-300 ml-auto group-hover/item:text-brand-primary"></i>
                </a>

                <a href="https://wa.me/6281234567892?text=Halo%20Admin" target="_blank" class="flex items-center gap-4 p-3 rounded-xl hover:bg-brand-soft/50 transition-colors group/item">
                    <div class="relative">
                        <div class="w-10 h-10 rounded-full bg-orange-100 flex items-center justify-center text-orange-600">
                            <i data-lucide="shield-check" class="w-5 h-5"></i>
                        </div>
                        <div class="absolute bottom-0 right-0 w-3 h-3 bg-gray-400 border-2 border-white rounded-full"></div>
                    </div>
                    <div>
                        <h4 class="font-bold text-slate-800 text-sm group-hover/item:text-brand-primary transition">After Sales</h4>
                        <p class="text-xs text-slate-500">Warranty & Spareparts</p>
                    </div>
                    <i data-lucide="chevron-right" class="w-4 h-4 text-slate-300 ml-auto group-hover/item:text-brand-primary"></i>
                </a>
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
    

    <script>
        // Init Icons
        lucide.createIcons();

        // Sticky Header Logic
        let lastScroll = 0;
        const header = document.getElementById('sticky-header');
        if (header) {
            window.addEventListener('scroll', () => {
                const currentScroll = window.pageYOffset;
                if (currentScroll <= 40) { 
                    header.style.transform = "translateY(0)";
                    return;
                }
                if (currentScroll > lastScroll && currentScroll > 100) {
                    header.style.transform = "translateY(-100%)"; // Hide on scroll down
                } else {
                    header.style.transform = "translateY(0)"; // Show on scroll up
                }
                lastScroll = currentScroll;
            });
        }

        // Sliders Logic
        document.addEventListener('DOMContentLoaded', () => {
            // Hero Slider
            const slides = document.querySelectorAll('.slide');
            const prevBtn = document.getElementById('prev-slide');
            const nextBtn = document.getElementById('next-slide');
            const dotsContainer = document.getElementById('dots-container');

            if (dotsContainer && slides.length > 0) {
                let currentSlide = 0;
                const slideCount = slides.length;
                let slideInterval;

                // Create Dots
                slides.forEach((_, index) => {
                    const dot = document.createElement('button');
                    dot.classList.add('w-2', 'h-2', 'rounded-full', 'transition-all', 'duration-300');
                    if (index === 0) dot.classList.add('bg-white', 'w-6');
                    else dot.classList.add('bg-white/40', 'hover:bg-white');
                    dot.addEventListener('click', () => { goToSlide(index); resetTimer(); });
                    dotsContainer.appendChild(dot);
                });

                const dots = dotsContainer.querySelectorAll('button');

                function updateSlides() {
                    slides.forEach((slide, index) => {
                        if (index === currentSlide) {
                            slide.classList.remove('slide-hidden');
                            slide.classList.add('slide-active');
                        } else {
                            slide.classList.add('slide-hidden');
                            slide.classList.remove('slide-active');
                        }
                    });
                    dots.forEach((dot, index) => {
                        if (index === currentSlide) {
                            dot.classList.remove('bg-white/40', 'w-2');
                            dot.classList.add('bg-white', 'w-6');
                        } else {
                            dot.classList.add('bg-white/40', 'w-2');
                            dot.classList.remove('bg-white', 'w-6');
                        }
                    });
                }

                function nextSlide() { currentSlide = (currentSlide + 1) % slideCount; updateSlides(); }
                function prevSlide() { currentSlide = (currentSlide - 1 + slideCount) % slideCount; updateSlides(); }
                function goToSlide(index) { currentSlide = index; updateSlides(); }
                function resetTimer() { clearInterval(slideInterval); slideInterval = setInterval(nextSlide, 6000); }

                if (nextBtn) nextBtn.addEventListener('click', () => { nextSlide(); resetTimer(); });
                if (prevBtn) prevBtn.addEventListener('click', () => { prevSlide(); resetTimer(); });

                resetTimer();
            }

            // Simple Horizontal Scroll (Categories & Certs)
            const setupScroll = (containerId, nextId, prevId) => {
                const container = document.getElementById(containerId);
                const next = document.getElementById(nextId);
                const prev = document.getElementById(prevId);
                
                if (container && next && prev) {
                    next.addEventListener('click', () => { container.scrollBy({ left: 320, behavior: 'smooth' }); });
                    prev.addEventListener('click', () => { container.scrollBy({ left: -320, behavior: 'smooth' }); });
                }
            };
            setupScroll('category-slider', 'cat-next', 'cat-prev');
            setupScroll('certification-slider', 'cert-next', 'cert-prev');
        });
    </script>
</body>
</html>