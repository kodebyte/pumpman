<x-web.main-layout>

    <div class="pt-14 pb-10 flex flex-col items-center justify-center bg-brand-gray px-4">
        {{-- CARD CONTAINER --}}
        <div class="w-full max-w-2xl bg-white rounded-[2.5rem] shadow-2xl overflow-hidden border border-gray-200/60 relative">
            {{-- HEADER HIJAU (Status) --}}
            <div class="bg-brand-primary p-10 text-center relative overflow-hidden">
                {{-- Pattern Overlay --}}
                <div class="absolute inset-0 opacity-10" style="background-image: radial-gradient(#ffffff 1px, transparent 1px); background-size: 20px 20px;"></div>
                
                <div class="relative z-10">
                    <div class="w-20 h-20 bg-white/20 backdrop-blur-sm rounded-full flex items-center justify-center mx-auto mb-6 shadow-inner ring-4 ring-white/10 animate-bounce-slow">
                        <i data-lucide="check" class="w-10 h-10 text-white"></i>
                    </div>
                    <h1 class="text-3xl font-black text-white uppercase tracking-tight mb-2">{{ __('Payment Successful!') }}</h1>
                    <p class="text-white/90 text-sm font-medium">{{ __('Transaction completed successfully.') }}</p>
                </div>
            </div>

            {{-- BODY CONTENT --}}
            <div class="p-8 md:p-12 text-center">
                
                <p class="text-slate-500 mb-8 text-lg leading-relaxed">
                    {!! __('Thank you! Your payment for Order ID :order_id has been received. We will process your order shortly.', ['order_id' => '<span class="font-black text-slate-900 text-xl mx-1">' . $order->order_number . '</span>']) !!}
                </p>

                {{-- Email Confirmation Box --}}
                <div class="bg-gray-50 rounded-2xl p-6 mb-10 border border-gray-100">
                    <div class="flex items-center justify-center gap-2 mb-2">
                        <i data-lucide="mail" class="w-4 h-4 text-brand-primary"></i>
                        <span class="text-xs font-bold uppercase tracking-wider text-slate-400">{{ __('Confirmation Sent To') }}</span>
                    </div>
                    <p class="font-black text-slate-900 text-xl break-all">{{ $order->email }}</p>
                </div>

                {{-- Action Buttons --}}
                <div class="flex flex-col gap-4">
                    <a href="{{ route('products.index') }}" class="w-full bg-brand-dark text-white py-4 rounded-xl font-bold uppercase tracking-widest hover:bg-brand-primary transition-all duration-300 shadow-lg transform hover:-translate-y-1 flex items-center justify-center gap-2 group">
                        <i data-lucide="shopping-bag" class="w-5 h-5 group-hover:scale-110 transition"></i>
                        {{ __('Continue Shopping') }}
                    </a>
                    
                    <a href="{{ route('home') }}" class="inline-flex items-center justify-center gap-2 text-xs font-bold text-slate-400 hover:text-brand-primary transition uppercase tracking-widest py-3 group">
                        <i data-lucide="arrow-left" class="w-3 h-3 group-hover:-translate-x-1 transition-transform"></i>
                        {{ __('Back to Home') }}
                    </a>
                </div>

            </div>

        </div>
    </div>

</x-web.main-layout>