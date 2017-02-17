<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class Pipeline extends Model
{
    public  $table = 'hz_pipeline';   
   	public $primaryKey = 'pipeline_id';
    public $timestamps = false;

    //获取队列信息
    public function getOne($pipeline_id)
    {
    	return $this->where('pipeline_id',$pipeline_id)
    			->select('pipeline_id','pipeline_name','pipeline_id','pipeline_description','output_type','input_bucket','input_bucket_access_key_id','input_bucket_access_key_secret','output_bucket','output_bucket_access_key_id','output_bucket_access_key_secret','notification_id','pipeline_capacity','pipeline_complicating','pipeline_complicating_now','state','pipeline_priority')
    			->where('state','1')
    			->first();
    }

    public function getInfoByPipelineId($pipeline_id,$column='*')
    {
        return DB::table($this->table)->where('pipeline_id',$pipeline_id)->select($column)->first();
    }

    public function addNum($pipeline_id)
    {

    	 return DB::update("UPDATE ".$this->table." SET `pipeline_complicating_now`=`pipeline_complicating_now`+1 WHERE pipeline_id=? ",[$pipeline_id]);
    }

    public function cancelNum($pipeline_id)
    {
         return DB::update("UPDATE ".$this->table." SET `pipeline_complicating_now`=`pipeline_complicating_now`-1 WHERE pipeline_id=? ",[$pipeline_id]);
    }

    //以下是后台
    public function adminList($begin=0,$page_size=15,$data=null)
    {
         
         return $this->select(
            'pipeline_id',
            'pipeline_name',
            'input_bucket',
            'output_bucket',
            'output_type',
            'pipeline_complicating_now',
            'state')->offset($begin)->limit($page_size)->get();
    }

    public function adminLength($data=null)
    {

        return $this->count();
    }

}
