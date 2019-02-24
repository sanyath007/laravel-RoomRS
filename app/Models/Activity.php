<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    protected $table = 'reserve_activity';
    protected $primaryKey = 'activity_type_id';
    public $incrementing = false; //ไม่ใช้ options auto increment
    // public $timestamps = false; //ไม่ใช้ field updated_at และ created_at

    public function reserve()
    {
        return $this->hasMany('App\Models\Reservation', 'activity_type_id', 'reserve_activity_type');
    }
}
