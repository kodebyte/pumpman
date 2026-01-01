<x-web.main-layout>

    {{-- 1. HEADER --}}
    {{-- CONSISTENCY: pt-32 pb-12, Uppercase 3XL Title --}}
    <div class="pt-14 pb-10  bg-brand-gray relative overflow-hidden">
        <div class="container mx-auto px-4 md:px-6 relative z-10">
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-6">
                <div>
                    <div class="flex items-center gap-2 text-xs font-bold uppercase tracking-wider text-slate-400 mb-3">
                        <a href="{{ route('home') }}" class="hover:text-brand-primary transition">{{ __('Home') }}</a>
                        <i data-lucide="chevron-right" class="w-3 h-3 text-slate-300"></i>
                        <span class="text-slate-400">{{ __('Support') }}</span>
                        <i data-lucide="chevron-right" class="w-3 h-3 text-slate-300"></i>
                        <span class="text-brand-primary">{{ __('Track Repair') }}</span>
                    </div>
                    <h1 class="text-3xl font-display font-bold text-slate-900 uppercase tracking-tight leading-tight">
                        {{ __('Check Status') }}
                    </h1>
                </div>
                <p class="text-slate-500 text-sm max-w-md text-left md:text-right leading-relaxed border-l-4 border-brand-primary pl-4 md:border-l-0 md:border-r-4 md:pr-4">
                    {{ __('Monitor the progress of your device repair in real-time with your service ticket number.') }}
                </p>
            </div>
        </div>
    </div>

    {{-- 2. MAIN TRACKING DASHBOARD --}}
    <section class="bg-brand-gray pb-24 relative z-0">
        <div class="container mx-auto px-4 md:px-6">
            
            {{-- SEARCH FORM CARD --}}
            <div class="max-w-2xl mx-auto mb-16">
                @if(session('error'))
                    <div class="bg-red-50 border border-red-200 text-red-800 p-4 rounded-xl mb-6 flex items-center gap-3 animate-fade-in-up">
                        <i data-lucide="alert-circle" class="w-5 h-5 flex-shrink-0"></i>
                        <span class="text-sm font-bold">{{ session('error') }}</span>
                    </div>
                @endif

                <form action="{{ route('warranty-claim.check') }}" method="GET">
                    <div class="bg-white p-2 rounded-2xl shadow-xl shadow-gray-200/50 border border-white flex items-center gap-2 focus-within:ring-2 focus-within:ring-brand-primary transition transform hover:-translate-y-1 duration-300">
                        <div class="pl-4 text-slate-400">
                            <i data-lucide="search" class="w-6 h-6"></i>
                        </div>
                        <input type="text" 
                               name="ticket"
                               value="{{ request('ticket') }}"
                               placeholder="{{ __('Enter Ticket Number (Ex: WCP-23...)') }}" 
                               class="w-full border-none focus:ring-0 text-lg font-bold placeholder-gray-300 py-4 text-slate-900 bg-transparent uppercase tracking-wider"
                               required>
                        <button type="submit" class="bg-brand-dark text-white px-8 py-3.5 rounded-xl font-bold hover:bg-brand-primary transition flex-shrink-0 uppercase tracking-wider text-sm shadow-lg">
                            {{ __('Track') }}
                        </button>
                    </div>
                </form>
                <p class="text-xs text-slate-400 mt-4 text-center">
                    {{ __('The ticket number can be found in the confirmation email or physical receipt.') }}
                </p>
            </div>

            {{-- RESULT CARD --}}
            @if(isset($claim))
                <div class="max-w-4xl mx-auto animate-fade-in-up">
                    
                    <div class="bg-white border border-gray-200 rounded-[2.5rem] overflow-hidden shadow-2xl">
                        
                        {{-- STATUS CONFIGURATION --}}
                        @php
                            $statusConfig = [
                                'pending'       => ['bg' => 'bg-gray-100', 'text' => 'text-slate-600', 'icon' => 'clock', 'label' => __('Waiting for Verification'), 'desc' => __('Your request is being reviewed by our admin team.')],
                                'approved'      => ['bg' => 'bg-blue-50', 'text' => 'text-blue-700', 'icon' => 'check-circle', 'label' => __('Approved'), 'desc' => __('Claim approved. Please send your unit according to the instructions in the email.')],
                                'unit_received' => ['bg' => 'bg-indigo-50', 'text' => 'text-indigo-700', 'icon' => 'package-check', 'label' => __('Unit Received'), 'desc' => __('The unit has arrived at the Service Center and is queuing for inspection.')],
                                'repairing'     => ['bg' => 'bg-yellow-50', 'text' => 'text-yellow-700', 'icon' => 'wrench', 'label' => __('Repairing'), 'desc' => __('A technician is repairing your unit.')],
                                'completed'     => ['bg' => 'bg-green-50', 'text' => 'text-green-700', 'icon' => 'check-circle-2', 'label' => __('Completed'), 'desc' => __('Repair completed. The unit is in the process of being shipped back.')],
                                'rejected'      => ['bg' => 'bg-red-50', 'text' => 'text-red-700', 'icon' => 'x-circle', 'label' => __('Rejected'), 'desc' => __('Sorry, the warranty claim cannot be processed. Check your email for details.')],
                            ];
                            
                            $currentStatus = $statusConfig[$claim->status] ?? $statusConfig['pending'];
                        @endphp

                        {{-- STATUS HEADER --}}
                        <div class="{{ $currentStatus['bg'] }} p-10 text-center border-b border-gray-100 relative overflow-hidden">
                            {{-- Pattern --}}
                            <div class="absolute inset-0 opacity-10" style="background-image: radial-gradient(#000 1px, transparent 1px); background-size: 20px 20px;"></div>
                            
                            <div class="relative z-10">
                                <div class="inline-flex p-4 rounded-2xl bg-white shadow-sm mb-4">
                                    <i data-lucide="{{ $currentStatus['icon'] }}" class="w-8 h-8 {{ $currentStatus['text'] }}"></i>
                                </div>
                                <h2 class="text-3xl font-black {{ $currentStatus['text'] }} mb-2 uppercase tracking-tight">{{ $currentStatus['label'] }}</h2>
                                <p class="text-slate-600 max-w-md mx-auto text-sm leading-relaxed">{{ $currentStatus['desc'] }}</p>
                            </div>
                        </div>

                        {{-- TICKET DETAILS --}}
                        <div class="p-8 md:p-12">
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-10 border-b border-gray-100 pb-10 mb-10">
                                
                                {{-- Column 1: Ticket Info --}}
                                <div>
                                    <h3 class="text-xs font-bold uppercase tracking-widest text-slate-400 mb-6 flex items-center gap-2">
                                        <i data-lucide="tag" class="w-4 h-4"></i> {{ __('Ticket Information') }}
                                    </h3>
                                    <div class="space-y-4">
                                        <div class="flex flex-col">
                                            <span class="text-[10px] uppercase font-bold text-slate-400 mb-1">{{ __('Ticket Number') }}</span>
                                            <span class="font-black text-2xl text-slate-900 tracking-tight">{{ $claim->claim_code }}</span>
                                        </div>
                                        <div class="flex flex-col">
                                            <span class="text-[10px] uppercase font-bold text-slate-400 mb-1">{{ __('Submission Date') }}</span>
                                            <span class="font-bold text-slate-700">{{ $claim->created_at->format('d M Y, H:i') }} WIB</span>
                                        </div>
                                        @if($claim->admin_tracking_number)
                                        <div class="bg-brand-soft/50 p-4 rounded-xl border border-brand-primary/20">
                                            <span class="text-[10px] uppercase font-bold text-brand-primary mb-1 block">{{ __('Return Shipment Receipt') }}</span>
                                            <div class="flex items-center gap-3">
                                                <span class="font-black text-slate-900 text-lg">
                                                    {{ $claim->admin_tracking_number }}
                                                </span>
                                                <button onclick="navigator.clipboard.writeText('{{ $claim->admin_tracking_number }}')" class="text-slate-400 hover:text-brand-primary transition" title="{{ __('Copy Receipt') }}">
                                                    <i data-lucide="copy" class="w-4 h-4"></i>
                                                </button>
                                            </div>
                                        </div>
                                        @endif
                                    </div>
                                </div>

                                {{-- Column 2: Applicant Data --}}
                                <div>
                                    <h3 class="text-xs font-bold uppercase tracking-widest text-slate-400 mb-6 flex items-center gap-2">
                                        <i data-lucide="user" class="w-4 h-4"></i> {{ __('Applicant Data') }}
                                    </h3>
                                    <div class="space-y-4">
                                        <div class="flex flex-col">
                                            <span class="text-[10px] uppercase font-bold text-slate-400 mb-1">{{ __('Customer Name') }}</span>
                                            <span class="font-bold text-slate-900 text-lg">{{ $claim->customer_name }}</span>
                                        </div>
                                        
                                        @php
                                            $email = '-';
                                            if (preg_match('/\(Email: (.*?)\)/', $claim->shipping_address, $matches)) {
                                                $email = $matches[1];
                                            } elseif ($claim->user) {
                                                $email = $claim->user->email;
                                            }
                                            
                                            // Masking Email
                                            $maskedEmail = $email;
                                            if ($email !== '-' && filter_var($email, FILTER_VALIDATE_EMAIL)) {
                                                $parts = explode('@', $email);
                                                $maskedEmail = substr($parts[0], 0, 1) . '****' . substr($parts[0], -1) . '@' . $parts[1];
                                            }
                                        @endphp

                                        <div class="flex flex-col">
                                            <span class="text-[10px] uppercase font-bold text-slate-400 mb-1">{{ __('Email') }}</span>
                                            <span class="font-bold text-slate-700">{{ $maskedEmail }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Product Detail Section --}}
                            <div>
                                <h3 class="text-xs font-bold uppercase tracking-widest text-slate-400 mb-6 flex items-center gap-2">
                                    <i data-lucide="package" class="w-4 h-4"></i> {{ __('Product Details & Issues') }}
                                </h3>
                                
                                <div class="bg-gray-50 rounded-2xl p-6 md:p-8 border border-gray-200">
                                    <div class="flex flex-col md:flex-row items-start gap-6 mb-6">
                                        <div class="w-16 h-16 bg-white rounded-2xl shadow-sm border border-gray-100 flex items-center justify-center flex-shrink-0 text-brand-primary">
                                            <i data-lucide="settings" class="w-8 h-8"></i>
                                        </div>
                                        <div>
                                            <h4 class="font-black text-xl text-slate-900">{{ $claim->product->name ?? __('Unknown Product') }}</h4>
                                            <div class="flex flex-wrap gap-4 mt-2">
                                                <span class="px-3 py-1 bg-white border border-gray-200 rounded-lg text-xs font-bold text-slate-500 flex items-center gap-1">
                                                    <i data-lucide="barcode" class="w-3 h-3"></i> SKU: {{ $claim->product->sku ?? '-' }}
                                                </span>
                                                <span class="px-3 py-1 bg-white border border-gray-200 rounded-lg text-xs font-bold text-slate-500 flex items-center gap-1">
                                                    <i data-lucide="hash" class="w-3 h-3"></i> SN: {{ $claim->serial_number }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="bg-white border border-gray-200 rounded-xl p-5 relative">
                                        <span class="absolute -top-3 left-4 bg-gray-50 px-2 text-[10px] font-bold uppercase text-slate-400 tracking-wider">
                                            {{ __('Problem Description') }}
                                        </span>
                                        <p class="text-slate-600 text-sm leading-relaxed">
                                            {{ $claim->description }}
                                        </p>
                                    </div>
                                </div>
                            </div>

                        </div>

                        {{-- Admin Notes (Yellow Alert) --}}
                        @if($claim->admin_notes)
                            <div class="bg-yellow-50 px-8 py-6 border-t border-yellow-100 flex gap-4 items-start">
                                <div class="bg-yellow-100 p-2 rounded-lg text-yellow-700 mt-0.5">
                                    <i data-lucide="message-square" class="w-5 h-5"></i>
                                </div>
                                <div>
                                    <h5 class="text-sm font-black text-yellow-900 uppercase tracking-wide mb-1">{{ __('Technician Note:') }}</h5>
                                    <p class="text-sm text-yellow-800 leading-relaxed">
                                        {{ $claim->admin_notes }}
                                    </p>
                                </div>
                            </div>
                        @endif
                    </div>

                    {{-- Action Button --}}
                    <div class="text-center mt-8">
                        <a href="https://wa.me/6281234567890?text=Halo%20Pumpman,%20saya%20ingin%20tanya%20tentang%20tiket%20{{ $claim->claim_code }}" target="_blank" class="inline-flex items-center gap-2 text-sm font-bold text-white bg-green-600 px-8 py-4 rounded-xl hover:bg-green-700 transition shadow-lg hover:shadow-xl hover:-translate-y-1 transform duration-200">
                            <i data-lucide="message-circle" class="w-5 h-5"></i>
                            {{ __('Contact CS via WhatsApp') }}
                        </a>
                    </div>
                </div>
            @else
                {{-- Empty State --}}
                <div class="text-center py-20 opacity-40">
                    <div class="bg-gray-100 w-24 h-24 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i data-lucide="search-check" class="w-12 h-12 text-gray-400"></i>
                    </div>
                    <p class="text-lg font-bold text-gray-400">{{ __('Please enter your ticket number to view status.') }}</p>
                </div>
            @endif

        </div>
    </section>

</x-web.main-layout>