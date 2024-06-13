<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categories extends Model
{
    use HasFactory;

    protected $table = 'categories';

    protected $primaryKey = 'id';
    
    public $timestamps = false;

    protected $fillable = [
        'category_name',
    ];

    public function movies()
    {
        return $this->belongsToMany(movie::class, 'movie_categories', 'category_id', 'movie_id');
    }
    
}
