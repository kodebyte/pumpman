<x-web.main-layout>

    <style>
        /* CSS KHUSUS PRINT */
        @media print {
            @page { margin: 0; size: auto; }
            body { 
                background-color: white; 
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
                color: black !important;
            }
            body * { visibility: hidden; }
            
            #invoice-area, #invoice-area * {
                visibility: visible;
            }
            #invoice-area {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
                margin: 0;
                padding: 40px;
                box-shadow: none !important;
                border: none !important;
                border-radius: 0 !important;
            }
            
            #action-bar, nav, footer, .fixed, header { display: none !important; }
            .no-print { display: none !important; }

            /* Paksa Layout Baris */
            .print-flex-row {
                display: flex !important;
                flex-direction: row !important;
                justify-content: space-between !important;
                align-items: flex-start !important;
            }
            .print-w-half { width: 48% !important; }
            .print-text-right { text-align: right !important; }
            .print-grid-3 {
                display: grid !important;
                grid-template-columns: repeat(3, 1fr) !important;
                gap: 20px !important;
            }
        }
    </style>

    <section class="bg-brand-gray pt-40 pb-24 min-h-screen">
        <div class="container mx-auto px-4 md:px-6">

            {{-- Action Bar --}}
            <div id="action-bar" class="max-w-4xl mx-auto mb-8 flex flex-col md:flex-row justify-between items-center gap-4">
                <a href="{{ route('orders.index') }}" class="flex items-center gap-2 text-xs font-bold uppercase tracking-widest text-slate-500 hover:text-brand-primary transition">
                    <i data-lucide="arrow-left" class="w-4 h-4"></i> {{ __('Back to Orders') }}
                </a>

                <div class="flex gap-3">
                    <button onclick="window.print()" class="flex items-center gap-2 px-5 py-2.5 bg-white border border-gray-200 rounded-xl text-xs font-bold hover:border-brand-dark transition shadow-sm text-slate-700">
                        <i data-lucide="printer" class="w-4 h-4"></i> {{ __('Print Invoice') }}
                    </button>
                    @if($order->payment_status == 'pending')
                        <a href="{{ $order->payment_url ?? '#' }}" target="_blank" class="flex items-center gap-2 px-5 py-2.5 bg-brand-primary text-white rounded-xl text-xs font-bold hover:bg-green-700 transition shadow-lg">
                            <i data-lucide="credit-card" class="w-4 h-4"></i> {{ __('Pay Now') }}
                        </a>
                    @endif
                </div>
            </div>

            {{-- INVOICE PAPER --}}
            <div id="invoice-area" class="max-w-4xl mx-auto bg-white p-10 md:p-16 rounded-[2rem] shadow-xl border border-gray-200/60 relative overflow-hidden">
                
                {{-- Decorative Strip --}}
                <div class="absolute top-0 left-0 w-full h-2 bg-brand-dark"></div>

                {{-- HEADER --}}
                <div class="flex flex-col md:flex-row justify-between items-start border-b-2 border-black pb-8 mb-8 print-flex-row">
                    <div class="print-w-half">
                        {{-- Ganti dengan Logo Pumpman --}}
                        <div class="text-2xl font-black text-brand-dark uppercase tracking-tighter mb-4">
                            PUMPMAN<span class="text-brand-primary">.</span>
                        </div>
                        <p class="text-xs text-slate-500 leading-relaxed font-medium">
                            <strong>PT. Pumpman Indonesia</strong><br>
                            Industrial Estate Blok A2<br>
                            Jl. Raya Industri No. 88<br>
                            Jakarta, Indonesia 14000<br>
                            finance@pumpman.co.id
                        </p>
                    </div>
                    
                    <div class="text-left md:text-right mt-6 md:mt-0 print-w-half print-text-right">
                        <h1 class="text-4xl font-black text-slate-200 tracking-tighter mb-2 select-none">{{ __('INVOICE') }}</h1>
                        <p class="text-lg font-bold text-brand-dark font-mono">#{{ $order->order_number }}</p>
                        <p class="text-xs text-slate-500 mb-2">{{ __('Date') }}: {{ $order->created_at->format('d M Y') }}</p>
                        
                        @php
                            $statusLabel = match($order->payment_status) {
                                'paid', 'settlement', 'success' => 'PAID',
                                'pending' => 'UNPAID',
                                'cancelled', 'expire', 'deny', 'failed' => 'VOID',
                                default => strtoupper($order->payment_status)
                            };
                            $statusClass = $statusLabel == 'PAID' ? 'border-green-500 text-green-700 bg-green-50' : 'border-red-500 text-red-700 bg-red-50';
                        @endphp
                        
                        <div class="mt-2">
                            <span class="inline-block px-4 py-1 rounded border-2 text-[10px] font-black tracking-widest {{ $statusClass }}">
                                {{ $statusLabel }}
                            </span>
                        </div>
                    </div>
                </div>

                {{-- INFO GRID --}}
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-12 print-grid-3">
                    <div>
                        <h4 class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">{{ __('Billed To') }}</h4>
                        <p class="font-bold text-slate-900 text-sm mb-1">{{ $order->first_name }} {{ $order->last_name }}</p>
                        <p class="text-xs text-slate-500 leading-relaxed">
                            {{ $order->email }}<br>
                            {{ $order->phone }}
                        </p>
                    </div>

                    <div>
                        <h4 class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">{{ __('Shipped To') }}</h4>
                        <p class="text-xs text-slate-500 leading-relaxed">
                            <strong class="text-slate-900">{{ $order->first_name }} {{ $order->last_name }}</strong><br>
                            {{ $order->address }}<br>
                            {{ $order->city_name }}, {{ $order->province_name }} {{ $order->postal_code }}<br>
                            Indonesia
                        </p>
                    </div>

                    <div>
                        <h4 class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">{{ __('Payment') }}</h4>
                        <p class="text-xs text-slate-900 font-bold mb-1">Midtrans Gateway</p>
                        @if(in_array($order->payment_status, ['paid', 'settlement', 'success']))
                            <p class="text-[10px] text-green-600 font-bold flex items-center gap-1">
                                <span class="w-2 h-2 rounded-full bg-green-500"></span> {{ __('Paid on') }} {{ $order->updated_at->format('d/m/Y') }}
                            </p>
                        @else
                            <p class="text-[10px] text-yellow-600 font-bold flex items-center gap-1">
                                <span class="w-2 h-2 rounded-full bg-yellow-500 animate-pulse"></span> {{ __('Awaiting Payment') }}
                            </p>
                        @endif
                    </div>
                </div>

                {{-- TABLE --}}
                <div class="border border-black rounded-lg overflow-hidden mb-8">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="bg-brand-dark text-white text-[10px] font-bold uppercase tracking-widest">
                                <th class="px-6 py-4">{{ __('Item Description') }}</th>
                                <th class="px-6 py-4 text-center">{{ __('Qty') }}</th>
                                <th class="px-6 py-4 text-right">{{ __('Price') }}</th>
                                <th class="px-6 py-4 text-right">{{ __('Total') }}</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 text-sm">
                            @foreach($order->items as $item)
                                <tr>
                                    <td class="px-6 py-4">
                                        <p class="font-bold text-slate-900">{{ $item->product_name }}</p>
                                        @if($item->variant_name)
                                            <p class="text-[10px] text-slate-500 font-mono mt-0.5">{{ __('VAR') }}: {{ $item->variant_name }}</p>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-center text-slate-600 font-mono">{{ $item->qty }}</td>
                                    <td class="px-6 py-4 text-right text-slate-600 font-mono">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                                    <td class="px-6 py-4 text-right font-bold text-slate-900 font-mono">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- FOOTER SUMMARY --}}
                <div class="flex flex-col md:flex-row justify-between items-start gap-8 print-flex-row">
                    
                    <div class="md:w-1/2 print-w-half">
                        <h4 class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">{{ __('Notes') }}</h4>
                        <div class="text-xs text-slate-500 leading-relaxed bg-gray-50 p-4 rounded-lg border border-gray-100 italic">
                            {{ __('Thank you for trusting Pumpman Indonesia. This document is a valid proof of purchase. Please retain for warranty purposes.') }}
                        </div>
                    </div>

                    <div class="md:w-1/3 w-full space-y-3 print-w-half">
                        @php $subtotal = $order->total_price - $order->shipping_price - $order->tax_price; @endphp

                        <div class="flex justify-between text-xs text-slate-600 font-medium">
                            <span>{{ __('Subtotal') }}</span>
                            <span class="font-mono">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between text-xs text-slate-600 font-medium">
                            <span>{{ __('Shipping') }}</span>
                            <span class="font-mono">Rp {{ number_format($order->shipping_price, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between text-xs text-slate-600 font-medium">
                            <span>{{ __('Tax (11%)') }}</span>
                            <span class="font-mono">Rp {{ number_format($order->tax_price, 0, ',', '.') }}</span>
                        </div>
                        <div class="border-t-2 border-black my-2 pt-3 flex justify-between items-end">
                            <span class="text-sm font-black text-brand-dark uppercase tracking-widest">{{ __('Total Due') }}</span>
                            <span class="text-2xl font-black text-brand-primary font-mono">Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>

                {{-- COPYRIGHT --}}
                <div class="border-t border-gray-100 mt-12 pt-8 text-center">
                    <p class="text-[10px] text-slate-400 uppercase tracking-widest">© {{ date('Y') }} PT. Pumpman Indonesia. {{ __('Official Invoice Document') }}</p>
                </div>
            </div>
        </div>
    </section>

</x-web.main-layout>