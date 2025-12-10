<nav id="navbar" class="fixed w-full z-50 transition-all duration-500 py-6 text-white bg-transparent">
    <div class="container mx-auto px-6 flex justify-between items-center">
        <a href="{{ route('home') }}" class="flex items-center gap-1 group cursor-pointer">
            <img src="{{ asset('assets/aiwa.png') }}" class="w-32" alt="Aiwa Indonesia">
        </a>

        <div id="desktop-menu" class="hidden md:flex items-center gap-8 text-sm font-medium tracking-wide transition-colors duration-300">
            <a href="{{ route('home') }}" class="hover:opacity-50 transition uppercase">Home</a>
            <a href="#" class="hover:opacity-50 transition uppercase">Products</a>
            <a href="#" class="hover:opacity-50 transition uppercase">About us</a>
            <a href="#" class="hover:opacity-50 transition uppercase">Contact us</a>
            <a href="#" class="hover:opacity-50 transition uppercase">Find store</a>
        </div>

        <div id="nav-icons" class="flex items-center gap-6 transition-colors duration-300">
            <i data-lucide="search" class="w-5 h-5 cursor-pointer hover:scale-110 transition"></i>
            <div class="relative cursor-pointer hover:scale-110 transition group">
                <i data-lucide="shopping-bag" class="w-5 h-5"></i>
                <span class="absolute -top-1 -right-1 w-2 h-2 bg-red-600 rounded-full"></span>
            </div>
            <button id="mobile-menu-btn" class="md:hidden">
                <i data-lucide="menu" class="w-6 h-6"></i>
            </button>
        </div>
    </div>

    <div id="mobile-menu" class="hidden absolute top-full left-0 w-full bg-white text-black shadow-lg border-t border-gray-100 p-6 flex-col gap-4 md:hidden">
        <a href="{{ route('home') }}" class="font-bold text-lg hover:text-red-600">Home</a>
        <a href="#" class="font-bold text-lg hover:text-red-600">Products</a>
        <a href="#" class="font-bold text-lg hover:text-red-600">About Us</a>
    </div>
</nav>