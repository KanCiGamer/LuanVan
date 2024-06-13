<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class seat_type extends Model
{
    use HasFactory;

    protected $table = 'seat_types';

    protected $primaryKey = 'seat_type_id';

    protected $fillable = [
        'name',
        'price',
    ];
    public function seat()
    {
        return $this->hasMany(seat::class, 'seat_type_id', 'seat_type_id');
    }
}
