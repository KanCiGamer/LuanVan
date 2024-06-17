<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class invoice_detail extends Model
{
    use HasFactory;

    protected $table = 'invoice_details';
    protected $primaryKey = 'id';
    protected $fillable = ['invoice_id','showtime_id', 'seat_id','gia_tien',];

    public function invoice()
    {
        return $this->belongsTo(invoice::class, 'invoice_id', 'invoice_id');
    }
    public function showTime()
    {
        return $this->belongsTo(show_time::class,'showtime_id','showtime_id');
    }
    public function seat()
    {
        return $this->belongsTo(Seat::class, 'seat_id', 'seat_id');
    }
}
