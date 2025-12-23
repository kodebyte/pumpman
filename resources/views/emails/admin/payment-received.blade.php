@component('mail::message')
# Pembayaran Diterima! 💰

Admin, pesanan **#{{ $order->order_number }}** telah berhasil dibayar dan siap untuk diproses.

@component('mail::panel')
**Total Dana Masuk:** Rp {{ number_format($order->total_price, 0, ',', '.') }}  
**Metode Pembayaran:** {{ strtoupper($order->payment_type) }}  
**Waktu Bayar:** {{ now()->format('d M Y, H:i') }} WIB
@endcomponent

**Ringkasan Produk:**
@component('mail::table')
| Produk | Qty |
| :--- | :---: |
@foreach($order->items as $item)
| {{ $item->product_name }} | {{ $item->qty }} |
@endforeach
@endcomponent

**Instruksi Selanjutnya:**
1. Periksa ketersediaan stok fisik.
2. Cetak Label Pengiriman/Invoice.
3. Serahkan paket ke kurir **{{ $order->courier->name ?? 'Pilihan Customer' }}**.
4. Update Nomor Resi di Dashboard Admin.

@component('mail::button', ['url' => route('admin.orders.show', $order->id), 'color' => 'red'])
Proses Pesanan Sekarang
@endcomponent

**Detail Pengiriman:** **Penerima:** {{ $order->first_name }} {{ $order->last_name }}  
**Alamat:** {{ $order->address }}, {{ $order->city_name }}, {{ $order->province_name }} {{ $order->postal_code }}  
**Telepon:** [{{ $order->phone }}](https://wa.me/{{ preg_replace('/[^0-9]/', '', $order->phone) }})

Terima kasih,<br>
Sistem Otomatis {{ config('app.name') }}
@endcomponent