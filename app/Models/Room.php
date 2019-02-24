<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
  	protected $table = 'room';
  	protected $primaryKey = 'room_id';
    // public $incrementing = false; //ไม่ใช้ options auto increment
    // public $timestamps = false; //ไม่ใช้ field updated_at และ created_at

  	public function reserve()
    {
        return $this->hasMany('App\Models\Reservation', 'room_id', 'reserve_room');
    }
}
