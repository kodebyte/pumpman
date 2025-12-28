<x-web.main-layout>

    {{-- 1. HEADER --}}
    <div class="pt-14 pb-10 bg-brand-gray relative overflow-hidden">
        <div class="container mx-auto px-4 md:px-6 relative z-10">
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-6">
                <div>
                    <div class="flex items-center gap-2 text-xs font-bold uppercase tracking-wider text-slate-400 mb-3">
                        <a href="{{ route('home') }}" class="hover:text-brand-primary transition">{{ __('Home') }}</a>
                        <i data-lucide="chevron-right" class="w-3 h-3 text-slate-300"></i>
                        <span class="text-brand-primary">{{ __('Tracking') }}</span>
                    </div>
                    <h1 class="text-3xl font-display font-bold text-slate-900 uppercase tracking-tight leading-tight">
                        {{ __('Track Order') }}
                    </h1>
                </div>
                <p class="text-slate-500 text-sm max-w-md text-left md:text-right leading-relaxed border-l-4 border-brand-primary pl-4 md:border-l-0 md:border-r-4 md:pr-4">
                    {{ __('Monitor the journey status of your industrial equipment in real-time from our warehouse to your site.') }}
                </p>
            </div>
        </div>
    </div>

    {{-- 2. MAIN CONTENT --}}
    <section class="bg-brand-gray pb-24 relative z-0">
        <div class="container mx-auto px-4 md:px-6">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 items-start">
                
                {{-- LEFT: SEARCH BOX (Sticky) --}}
                <div class="lg:col-span-4 space-y-8">
                    <div class="bg-white rounded-[2rem] p-8 border border-gray-200/60 shadow-lg sticky top-32">
                        <h3 class="font-black text-lg mb-6 flex items-center gap-2 uppercase tracking-wide text-slate-900">
                            <i data-lucide="search" class="w-5 h-5 text-brand-primary"></i>
                            {{ __('Track Another') }}
                        </h3>
                        
                        <form action="{{ route('order-tracking') }}" method="GET" class="space-y-4">
                            <div>
                                <label class="block text-[10px] font-bold uppercase text-slate-400 tracking-widest mb-2">{{ __('Order Number') }}</label>
                                <input type="text" name="order_number" value="{{ request('order_number') }}"
                                    class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:ring-1 focus:ring-brand-primary focus:border-brand-primary transition font-mono font-bold text-slate-900 bg-gray-50 focus:bg-white placeholder-gray-300" 
                                    placeholder="ORD-XXXX...">
                            </div>
                            <button type="submit" class="w-full bg-brand-dark text-white font-bold py-3.5 rounded-xl hover:bg-brand-primary transition-all duration-300 shadow-md uppercase tracking-widest text-xs">
                                {{ __('Track Now') }}
                            </button>
                        </form>
                    </div>
                </div>

                {{-- RIGHT: RESULT --}}
                <div class="lg:col-span-8">
                    @if(isset($order))
                        
                        {{-- 1. Status Stepper --}}
                        <div class="bg-white rounded-[2rem] border border-gray-200/60 p-10 shadow-sm mb-8 relative overflow-hidden">
                            <div class="flex justify-between items-center relative">
                                @php 
                                    $steps = ['pending', 'processing', 'completed']; 
                                    $currentIdx = array_search($order->status, $steps);
                                @endphp

                                {{-- Connector Line Background --}}
                                <div class="absolute left-0 top-6 w-full h-1 bg-gray-100 z-0 rounded-full"></div>
                                
                                {{-- Active Line --}}
                                <div class="absolute left-0 top-6 h-1 bg-brand-primary z-0 rounded-full transition-all duration-1000"
                                     style="width: {{ ($currentIdx / (count($steps) - 1)) * 100 }}%"></div>

                                @foreach($steps as $index => $step)
                                    <div class="flex flex-col items-center flex-1 relative z-10">
                                        {{-- Dot --}}
                                        <div class="w-12 h-12 rounded-full flex items-center justify-center transition-all duration-500 border-4 border-white shadow-lg
                                            {{ $index <= $currentIdx ? 'bg-brand-primary text-white' : 'bg-gray-200 text-gray-400' }}">
                                            @if($index < $currentIdx)
                                                <i data-lucide="check" class="w-5 h-5"></i>
                                            @else
                                                <i data-lucide="{{ $index == 0 ? 'file-text' : ($index == 1 ? 'package' : 'truck') }}" class="w-5 h-5"></i>
                                            @endif
                                        </div>
                                        <span class="mt-4 text-[10px] font-black uppercase tracking-widest {{ $index <= $currentIdx ? 'text-brand-dark' : 'text-gray-300' }}">
                                            {{ __(ucfirst($step)) }}
                                        </span>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        {{-- 2. Courier Info --}}
                        @if($order->tracking_number)
                            <div class="bg-brand-dark rounded-[2rem] p-8 text-white mb-8 flex flex-col md:flex-row justify-between items-center gap-6 shadow-xl relative overflow-hidden group">
                                {{-- Decor --}}
                                <div class="absolute top-0 right-0 w-40 h-40 bg-brand-primary rounded-full blur-[60px] opacity-20 group-hover:opacity-30 transition"></div>

                                <div class="flex items-center gap-5 relative z-10">
                                    <div class="w-14 h-14 bg-white/10 rounded-xl flex items-center justify-center backdrop-blur-sm border border-white/10">
                                        <i data-lucide="truck" class="w-6 h-6 text-brand-primary"></i>
                                    </div>
                                    <div>
                                        <h4 class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">
                                            {{ __('Courier Service') }}
                                        </h4>
                                        <div class="flex items-center gap-3">
                                            <span class="text-xl font-mono font-black tracking-tight">{{ $order->tracking_number }}</span>
                                            <div x-data="initCopyResi('{{ $order->tracking_number }}')" class="relative">
                                                <button @click="copy()" class="text-gray-400 hover:text-white transition" title="{{ __('Copy') }}">
                                                    <i :data-lucide="copied ? 'check' : 'copy'" class="w-4 h-4"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <p class="text-xs text-gray-400 mt-1 font-bold">{{ $order->courier->name ?? 'Express Delivery' }}</p>
                                    </div>
                                </div>
                                
                                @php
                                    $trackingLink = $order->courier 
                                        ? $order->courier->getTrackingLink($order->tracking_number)
                                        : 'https://www.google.com/search?q=cek+resi+' . $order->tracking_number;
                                @endphp
                                
                                <a href="{{ $trackingLink }}" target="_blank" 
                                    class="bg-white text-brand-dark px-6 py-3 rounded-xl font-bold text-xs uppercase tracking-widest hover:bg-brand-primary hover:text-white transition-all shadow-lg flex items-center gap-2 relative z-10">
                                    {{ __('Check Location') }} <i data-lucide="external-link" class="w-3 h-3"></i>
                                </a>
                            </div>
                        @endif

                        {{-- 3. Timeline --}}
                        <div class="bg-white rounded-[2rem] border border-gray-200/60 p-8 shadow-sm">
                            <h3 class="text-lg font-black text-slate-900 mb-8 flex items-center gap-2 uppercase tracking-wide">
                                <i data-lucide="clock" class="w-5 h-5 text-brand-primary"></i>
                                {{ __('Timeline History') }}
                            </h3>
                            
                            <div class="relative ml-3 border-l-2 border-dashed border-gray-200 space-y-8 pb-2">
                                @foreach($order->histories as $history)
                                    <div class="relative pl-8 group">
                                        {{-- Dot --}}
                                        <div class="absolute -left-[9px] top-1 w-4 h-4 rounded-full border-2 border-white shadow-sm transition-colors duration-300
                                            {{ $loop->first ? 'bg-brand-primary ring-4 ring-green-100' : 'bg-gray-300' }}">
                                        </div>
                                        
                                        <div class="flex flex-col md:flex-row md:items-start justify-between gap-2">
                                            <div>
                                                <h4 class="text-sm font-bold text-slate-900 uppercase tracking-wide {{ $loop->first ? 'text-brand-primary' : '' }}">
                                                    {{ __(ucfirst($history->status)) }}
                                                </h4>
                                                <p class="text-sm text-slate-500 leading-relaxed mt-1 bg-gray-50 p-3 rounded-lg border border-gray-100 inline-block">
                                                    {{ $history->notes }}
                                                </p>
                                            </div>
                                            <span class="text-[10px] font-mono text-slate-400 bg-white border border-gray-100 px-2 py-1 rounded whitespace-nowrap">
                                                {{ $history->created_at->format('d M Y, H:i') }}
                                            </span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @else
                        {{-- Empty State --}}
                        <div class="bg-white rounded-[2.5rem] p-16 text-center border-2 border-dashed border-gray-200">
                            <div class="bg-gray-50 w-24 h-24 rounded-full flex items-center justify-center mx-auto mb-6 shadow-sm">
                                <i data-lucide="package-search" class="w-10 h-10 text-slate-300"></i>
                            </div>
                            <h3 class="text-xl font-black text-slate-900 mb-2">{{ __('Start Tracking') }}</h3>
                            <p class="text-slate-500 text-sm max-w-xs mx-auto mb-6">{{ __('Enter your Order ID on the left panel to see the current status of your shipment.') }}</p>
                        </div>
                    @endif
                </div>

            </div>
        </div>
    </section>

    @push('scripts')
        <script>
            function initCopyResi(text) {
                return {
                    copied: false,
                    copy() {
                        if (navigator.clipboard && window.isSecureContext) {
                            navigator.clipboard.writeText(text).then(() => this.showFeedback());
                        } else {
                            // Fallback logic
                            alert('Copied to clipboard!'); 
                        }
                    },
                    showFeedback() {
                        this.copied = true;
                        this.$nextTick(() => { if(window.lucide) lucide.createIcons(); });
                        setTimeout(() => {
                            this.copied = false;
                            this.$nextTick(() => { if(window.lucide) lucide.createIcons(); });
                        }, 2000);
                    }
                }
            }
        </script>
    @endpush

</x-web.main-layout>