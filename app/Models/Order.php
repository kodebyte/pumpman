<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Cache;

class Order extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [
        'id'
    ];

    protected $casts = [
        'payment_info' => 'array', 
        'created_at'   => 'datetime',
        'updated_at'   => 'datetime',
        'total_price'  => 'decimal:2',
        'shipping_price' => 'decimal:2',
        'tax_price'    => 'decimal:2',
    ];

    protected static function booted()
    {
        // Hapus cache setiap kali ada order baru, update status, atau hapus data
        static::saved(fn () => Cache::forget('new_orders_count'));
        
        static::deleted(fn () => Cache::forget('new_orders_count'));
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    // Relasi ke User (Pemesan)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function province()
    {
        return $this->belongsTo(Province::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function district()
    {
        return $this->belongsTo(District::class);
    }

    public function histories() {
        return $this->hasMany(OrderHistory::class);
    }

    public function courier()
    {
        return $this->belongsTo(Courier::class)->withDefault([
            'name' => 'Kurir Lainnya',
            'code' => 'custom',
            'tracking_url_format' => null // Akan fallback ke Google Search di model Courier
        ]);
    }
}
