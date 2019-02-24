<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Equipment extends Model
{
    protected $table = 'reserve_equipment';
    protected $primaryKey = 'equipment_id';
    // public $incrementing = false; //ไม่ใช้ options auto increment
    // public $timestamps = false; //ไม่ใช้ field updated_at และ created_at

    // public function reserve()
    // {
    //     return $this->belongsTo('App\Models\Reservation', 'equipment_id', 'reserve_equipment');
    // }
}
