<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class user_role extends Model
{
    use HasFactory;

    protected $table = 'user_roles';

    protected $primaryKey = 'role_id';
    
    public $timestamps = false;

    protected $fillable = [
        'role_id',
        'role_name',
    ];
}
