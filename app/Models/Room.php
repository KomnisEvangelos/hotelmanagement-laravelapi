<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;

    protected $table = 'rooms';

   protected $fillable =[
    'room_number',
    'floor',
    'type',
    'price_per_night',
    'availability_status'
   ];
}
