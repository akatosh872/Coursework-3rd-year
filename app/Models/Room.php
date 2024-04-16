<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;

    protected $table = 'rooms';

    protected $fillable = [
        'id',
        'hotel_id',
        'type_id',
        'beds',
        'price_per_night',
        'square_meters',
        'number'
    ];

    public function hotel()
    {
        return $this->belongsTo(Hotel::class);
    }

    public function photos()
    {
        return $this->hasMany(Photo::class);
    }

    public function amenities()
    {
        return $this->belongsToMany(Amenity::class);
    }

    public function type()
    {
        return $this->belongsTo(RoomType::class);
    }
}
