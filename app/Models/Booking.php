<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Booking extends Model
{
    protected $primaryKey = 'booking_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'booking_id',
        'user_id',
        'booking_code',
        'maskapai',
        'kode_penerbangan',
        'from',
        'to',
        'from_code',
        'to_code',
        'tanggal',
        'berangkat',
        'tiba',
        'durasi',
        'kelas',
        'jumlah_penumpang',
        'harga_tiket',
        'pajak',
        'biaya_layanan',
        'total_harga',
        'contact_name',
        'contact_phone',
        'contact_email',
        'payment_status',
        'payment_method',
        'paid_at',
    ];

    protected $casts = [
        'paid_at' => 'datetime',
        'booked_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}