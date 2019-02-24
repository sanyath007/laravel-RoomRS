<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    protected $table = 'reservation';
    protected $primaryKey = 'Reserve_id';
    // public $incrementing = false; //ไม่ใช้ options auto increment
    // public $timestamps = false; //ไม่ใช้ field updated_at และ created_at
    
    public function activity()
  	{
      	return $this->belongsTo('App\Models\Activity', 'reserve_activity_type', 'activity_type_id');
  	}

  	public function room()
  	{
      	return $this->belongsTo('App\Models\Room', 'reserve_room', 'room_id');
  	}

  	public function layout()
    {
        return $this->belongsTo('App\Models\Layout', 'reserve_layout', 'reserve_layout_id');
    }

    public function user()
  	{
      	return $this->belongsTo('App\Models\User', 'reserve_user', 'person_id');
  	}

   //  public function payment_detail()
  	// {
   //    	return $this->hasMany('App\Models\PaymentDetail', 'payment_id', 'payment_id');
  	// }
}
