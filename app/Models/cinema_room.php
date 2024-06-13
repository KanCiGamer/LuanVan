<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class cinema_room extends Model
{
    use HasFactory;

        
    protected $table = 'cinema_rooms';

    protected $primaryKey = 'cinema_room_id';

    protected $fillable = [
        'cinema_room_name',
        'cinema_id',
    ];


    public function cinema()
    {
        return $this->belongsTo(cinema::class, 'cinema_id', 'cinema_id');
    }

    public function seat()
    {
        return $this->hasMany(seat::class, 'cinema_room_id', 'cinema_room_id');
    }

    public function show_times()
    {
        return $this->hasMany(show_time::class, 'cinema_room_id', 'cinema_room_id');
    }
}
