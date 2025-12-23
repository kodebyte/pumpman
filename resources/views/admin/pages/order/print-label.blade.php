<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Label - {{ $order->order_number }}</title>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        @media print {
            body { -webkit-print-color-adjust: exact; print-color-adjust: exact; }
            @page { margin: 0; size: auto; }
            .no-print { display: none !important; }
        }
    </style>
</head>
<body class="bg-gray-100 min-h-screen flex flex-col items-center justify-center p-4">

    <div class="no-print fixed top-4 right-4 flex gap-2">
        <button onclick="window.print()" class="bg-blue-600 text-white px-4 py-2 rounded shadow font-bold hover:bg-blue-700">
            Print Label
        </button>
        <button onclick="window.close()" class="bg-gray-500 text-white px-4 py-2 rounded shadow font-bold hover:bg-gray-600">
            Close
        </button>
    </div>

    <div class="bg-white w-[10cm] min-h-[15cm] border-2 border-black p-4 relative box-border shadow-lg">
        
        <div class="flex justify-between items-start border-b-2 border-black pb-4 mb-4">
            <div>
                <img src="{{ asset('assets/web/images/aiwa.png') }}" class="h-8 mb-1" alt="Aiwa">
                <p class="text-[10px] font-bold text-gray-500">PRIORITY SHIPPING</p>
            </div>
            <div class="text-right">
                <h1 class="text-xl font-black">JNE / J&T</h1> <p class="text-xs font-mono">Weight: 2 kg</p> </div>
        </div>

        <div class="text-center mb-6">
            <h2 class="text-2xl font-black tracking-widest border-2 border-dashed border-gray-300 py-2">
                {{ $order->order_number }}
            </h2>
            <p class="text-[10px] text-gray-400 mt-1">Order ID Reference</p>
        </div>

        <div class="mb-8">
            <p class="text-xs font-bold text-gray-500 uppercase mb-1">PENERIMA (To):</p>
            <h3 class="text-xl font-black leading-tight mb-1">{{ $order->first_name }} {{ $order->last_name }}</h3>
            <p class="text-sm font-bold mb-1">{{ $order->phone }}</p>
            <p class="text-sm leading-snug text-gray-800">
                {{ $order->address }}<br>
                {{ $order->city_name }}, {{ $order->province_name }}<br>
                {{ $order->postal_code }}
            </p>
        </div>

        <div class="border-t-2 border-black pt-4">
            <p class="text-[10px] font-bold text-gray-500 uppercase mb-1">PENGIRIM (From):</p>
            <div class="flex justify-between items-end">
                <div>
                    <h4 class="font-bold text-sm">PT. Aiwa Indonesia</h4>
                    <p class="text-xs">021-1234-5678</p>
                    <p class="text-[10px] text-gray-500 w-40 leading-tight mt-1">
                        Gedung Cyber 2, Lt 15, Jl. Rasuna Said, Jakarta Selatan.
                    </p>
                </div>
                <div class="border border-black p-1">
                    <img src="https://api.qrserver.com/v1/create-qr-code/?size=60x60&data={{ $order->order_number }}" class="w-16 h-16">
                </div>
            </div>
        </div>

        <div class="mt-4 pt-2 border-t border-dashed border-gray-400">
            <p class="text-[10px] font-bold">NOTES:</p>
            <p class="text-[10px] italic">Barang Elektronik Mudah Pecah. Mohon ditangani dengan hati-hati. Wajib Video Unboxing.</p>
        </div>
    </div>
</body>
</html>