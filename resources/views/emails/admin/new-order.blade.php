@component('mail::message')
# Pesanan Baru Masuk! 🚀

Halo Admin, ada pesanan baru dengan nomor **#{{ $order->order_number }}**. Berikut adalah ringkasannya:

**Detail Pelanggan:**
- **Nama:** {{ $order->first_name }} {{ $order->last_name }}
- **Email:** {{ $order->email }}
- **Telepon:** [{{ $order->phone }}](https://wa.me/{{ preg_replace('/[^0-9]/', '', $order->phone) }}) (Klik untuk WhatsApp)

**Informasi Pengiriman:**
{{ $order->address }}, {{ $order->city_name }}, {{ $order->province_name }} {{ $order->postal_code }}

@component('mail::table')
| Produk | Qty | Subtotal |
| :--- | :---: | ---: |
@foreach($order->items as $item)
| {{ $item->product_name }} | {{ $item->qty }} | Rp {{ number_format($item->subtotal, 0, ',', '.') }} |
@endforeach
| **Total Tagihan** | | **Rp {{ number_format($order->total_price, 0, ',', '.') }}** |
@endcomponent

**Status Pembayaran:** `{{ strtoupper($order->payment_status) }}`  
**Metode:** {{ strtoupper($order->payment_type ?? 'Belum memilih') }}

@component('mail::button', ['url' => route('admin.orders.show', $order->id), 'color' => 'red'])
Buka Dashboard Admin
@endcomponent

Terima kasih,<br>
Sistem Otomatis {{ config('app.name') }}
@endcomponent