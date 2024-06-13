<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class show_time extends Model
{
    use HasFactory;

    protected $table = 'show_times';

    protected $primaryKey = 'showtime_id';

    protected $fillable = [
        'movie_id',
        'cinema_room_id',
        'start_date',
        'start_time',
    ];

    public function movie()
    {
        return $this->belongsTo(movie::class, 'movie_id', 'movie_id');
    }

    public function cinema_room()
    {
        return $this->belongsTo(cinema_room::class, 'cinema_room_id', 'cinema_room_id');
    }
}
