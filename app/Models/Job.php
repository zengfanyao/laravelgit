<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
      
   	public  $table = 'hz_job';   
   	public $primaryKey = 'job_id';
      public $timestamps = false;

   	//查出要转码任务的数目
   	public function getJobLen($len='5')
   	{
   		return $this->where('state','0')->select($this->primaryKey)->limit($len)->get();

   	}
   	//查出正在转码的数目
   	public function getTcLen()
   	{
   		return $this->where('state','2')->count();
   	}
      //更新任务状态
      public function setState($data)
      {
         return $this->where('job_id',$data['job_id'])->update($data);
      }

      public function getOne($job_id)
      {
            return $this->where('job_id',$job_id)->select('job_id','pipeline_id','pipeline_id','input_file','output_file','preset_id','state')->first();
      }
      //分页
      public function adminJobLength($data=null)
      {
        
         return $this->where('state',1)->count();
      }

      public function adminJobList($begin=0,$page_size=15,$data=null)
      {  
        
        return $this->where('state',1)->select('job_id')->offset($begin)->limit($page_size)->get();
      }


}
