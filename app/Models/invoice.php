<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User;

class invoice extends Model
{
    use HasFactory;

    protected $table = 'invoices';

    protected $primaryKey = 'invoice_id';

    protected $fillable = [
        'invoice_id',
        'date_created',
        'status',
        'email_kh',
        'user_id',
        'discount_code_id',
    ];

    public function user()
    {
        return $this->belongsTo(Users::class, 'user_id', 'user_id');
    }

    public function discountCode()
    {
        return $this->belongsTo(discount_code::class, 'discount_code_id', 'discount_code_id');
    }
    public function invoice_detail()
    {
        return $this->hasMany(invoice_detail::class,'invoice_id','invoice_id');
    }
}
