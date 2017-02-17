<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notificationjob extends Model
{
    public  $table ='hz_notification_job';   
   	public $primaryKey = 'send_job_id';
    public $timestamps = false;
    public function getState($state,$len)
    {
    	return $this->where('state',$state)
    				->select('notification_id','notification_data','notification_url')
    				->limit($len)->get();
    }

    public function getOne($sendJobId)
    {
    	return $this->where('send_job_id',$sendJobId)
    			->select('send_job_id','notification_url','notification_data','state','send_time','failures_times')->first();
    }
    //获取待通知列表
    public function getIdJobLists($length)
    {
    	return $this->where('add_time', '>=',time()-(1*24*60*60))
    				->where('send_time','<=',time())
    				->where('state',0)
    				->select('send_job_id')
    				->limit($length)
    				->get();
    }

    public function setState($data,$sendJobId)
    {
    	return $this->where('send_job_id',$sendJobId)->update($data);
    }
}
