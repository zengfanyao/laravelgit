<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
   	public  $table ='hz_notification';   
   	public $primaryKey = 'notification_id';
    public $timestamps = false;

    public function getOne($notification_id)
    {
    	return $this->where('notification_id',$notification_id)
    			->select('notification_id','notification_name','notification_url')
    			->first();
    }



}
