<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class seat extends Model
{
    use HasFactory;

    protected $table = 'seats';

    protected $primaryKey = 'seat_id';
    
    protected $fillable = [
        'seat_name', 
        'cinema_room_id', 
        'seat_type_id'
    ];

    public function cinema_room()
    {
        return $this->belongsTo(cinema_room::class, 'cinema_room_id', 'cinema_room_id');
    }

    public function seat_type()
    {
        return $this->belongsTo(seat_type::class, 'seat_type_id', 'seat_type_id');
    }
}
