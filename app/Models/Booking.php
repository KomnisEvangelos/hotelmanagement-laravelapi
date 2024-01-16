<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $table = 'bookings';

   protected $fillable =[
    'customer_id',
    'room_id',
    'check_in_date',
    'check_out_date',
    'total_price',
    'payment_status',
   ];
}
