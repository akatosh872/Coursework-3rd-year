<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $table = 'bookings';

    protected $fillable = [
        'id',
        'room_id',
        'user_name',
        'user_id',
        'user_contact',
        'payment_method_id',
        'check_in_date',
        'check_out_date',
        'guest',
        'payment',
    ];

    public function room()
    {
        return $this->belongsTo(Room::class);
    }
    public function payment_method()
    {
        return $this->belongsTo(Payment_method::class);
    }
}
