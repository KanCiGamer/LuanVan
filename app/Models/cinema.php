<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class cinema extends Model
{
    use HasFactory;

    protected $table = 'cinemas';

    protected $primaryKey = 'cinema_id';

    protected $fillable = [
        'name',
        'address',
    ];

    public function cinema_rooms()
    {
        return $this->hasMany(cinema_room::class, 'cinema_id', 'cinema_id');
    }
}
