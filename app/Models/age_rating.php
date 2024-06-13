<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class age_rating extends Model
{
    use HasFactory;
    
    protected $table = 'age_ratings';

    protected $primaryKey = 'age_rating_id';

    public function movie()
    {
        return $this->hasMany(movie::class, 'age_rating_id', 'age_rating_id');
    }
}
