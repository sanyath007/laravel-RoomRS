<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Layout extends Model
{
    protected $table = 'reserve_layout';
    protected $primaryKey = 'reserve_layout_id';
    public $incrementing = false; //ไม่ใช้ options auto increment
    public $timestamps = false; //ไม่ใช้ field updated_at และ created_at

    public function reserve()
    {
        return $this->hasMany('App\Models\Reservation', 'reserve_layout_id', 'reserve_layout');
    }
}
