<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Hotel extends Model
{
    use HasFactory;

    protected $table = 'hotels';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        'name',
        'description',
        'location',
        'stars',
        'photo',
        'admin_id'
    ];

    public function rooms(): HasMany
    {
        return $this->hasMany(Room::class);
    }

    /**
     * Каскадне видалення номерів прив'язаних до номеру
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($hotel) {
            $hotel->rooms()->each(function ($room) {
                $room->delete();
            });
        });
    }
}
