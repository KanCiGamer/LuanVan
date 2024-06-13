<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class movie extends Model
{
    use HasFactory;

      // Sử dụng UUID thay cho ID mặc định
      protected $keyType = 'string';
      public $incrementing = false;
  
      // Tên bảng
      protected $table = 'movies';
  
      // Khóa chính
      protected $primaryKey = 'movie_id';
  
      // Các trường có thể gán
      protected $fillable = [
          'movie_id',
          'movie_name',
          'nation',
          'directors',
          'actor',
          'language',
          'description',
          'poster',
          'trailer_link',
          'time',
          'price',
          'status',
          'age_rating_id',
      ];
  
      // Các trường có kiểu dữ liệu đặc biệt
      protected $casts = [
          'movie_id' => 'string',
          'status' => 'boolean',
      ];

    public function age_rating()
    {
        return $this->belongsTo(age_rating::class, 'age_rating_id', 'age_rating_id');
    }

    public function categories()
    {
        return $this->belongsToMany(categories::class, 'movie_categories', 'movie_id', 'category_id');
    }

    public function show_time()
    {
        return $this->hasMany(show_time::class, 'movie_id', 'movie_id');
    }
    
}
