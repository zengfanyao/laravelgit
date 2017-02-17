<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Models\Notificationjob;
use DB;
use App\Http\Controllers\FrontController;

class NotificationController extends FrontController
{
    private $notification_con = [
        'notification_id' => 'required|numeric'
    ];

    private $notification_save = [
        'notification_url' =>'required',
        'notification_data' =>'required',
        'add_time' =>'required'
    ];

    private $notification_all = [
        'state' =>'required|numeric',
        'len'   =>'required|numeric'
    ];

    private $notification_one = [
        'send_job_id' => 'required|numeric'
    ];

    private $notification_id = [
        'length' => 'required|numeric'
    ];

    private $notification_lock = [
        'send_job_id'=>'required|numeric'
    ];
    private $notification_state = [
        'send_job_id' =>'required|numeric',
        'state'     =>'required|numeric'
    ];
    private $notification_data = [
        'send_job_id' =>'required|numeric',
        'send_time'=>'required|numeric',
        'failures_times'=>'required|numeric',
        'state'=>'required|numeric',
        'error_msg'=>'required|numeric',
    ];

	private $notification;
    public function __construct()
    {
    	parent::__construct();
    	$this->notification=new Notification;

    }

    public function index()
    {
    	$request=\Request::all();
    	$v=\Validator::make($request,$this->notification_con);
    	if ($v->fails())
    	{
    		 $this->abortCode(404,"参数错误");
    	}
    	$notification_id=$request['notification_id'];
    	$result=$this->notification->getOne($notification_id);
    	return $this->r(['data'=>$result]);
    }
    //保存通知列表
    public function save()
    {
        $request=\Request::all();
        $v=\Validator::make($request,$this->notification_save);
        if ($v->fails())
        {
             $this->abortCode(404,"参数错误");
        }

        $insert_data=[
            'notification_url'=>$request['notification_url'],
            'notification_data'=>$request['notification_data'],
            'add_time'=>$request['add_time'],
        ];
        DB::table("hz_notification_job")->insert(
                [$insert_data]
            );
        return $this->r();
    }
    //获取多个
    public function get()
    {
        $request=\Request::all();
        $v=\Validator::make($request,$this->notification_save);
        if ($v->fails())
        {
             $this->abortCode(404,"参数错误");
        }
        $state=$request['state'];
        $len=$request['len'];
        $notificationModel=new Notificationjob;
        $data=$notificationModel->getState($state,$len);
        return $this->r(['list'=>$data]);
    }
    //获取单个
    public function one()
    {
        $request=\Request::all();
        $v=\Validator::make($request,$this->notification_one);
        if ($v->fails())
        {
             $this->abortCode(404,"参数错误");
        }
        $sendJobId=$request['send_job_id'];
        $notificationJobModel=new Notificationjob;
        $data=$notificationJobModel->getOne($sendJobId);
        return $this->r(['data'=>$data]);

    }
    //获取待通知列表id
    public function getid()
    {
        $request=\Request::all();
        $v=\Validator::make($request,$this->notification_id);
        if ($v->fails())
        {
             $this->abortCode(404,"参数错误");
        }
        $length=$request['length'];
        $notificationJobModel=new Notificationjob;
        $data=$notificationJobModel->getIdJobLists($length);
        return $this->r(['list'=>$data]);
    }
    //加锁
    public function lock()
    {
        $request=\Request::all();
        $v=\Validator::make($request,$this->notification_lock);
        if ($v->fails())
        {
             $this->abortCode(404,"参数错误");
        }
        $sendJobId=$request['send_job_id'];
        $notificationJobModel=new Notificationjob;
        try{
            DB::beginTransaction();
             $r =$notificationJobModel->getOne($sendJobId);
             if (empty($r))
             {
                throw new Exception("Error Processing Request", 1);
                
             }
             if ((int)$r->state!==0)
             {
                throw new Exception("Error Processing Request", 1);
                
             }
             $updateData= [
                'state' => '-2'
             ];
             $state=$notificationJobModel->setState($updateData,$sendJobId);
             if (empty($state))
             {
                throw new Exception("Error Processing Request", 1);
                
             }

        }catch(Exception $e) 
        {
             DB::rollBack();
            $this->abortCode(404,"操作失败");
        }
        DB::commit();
        return $this->r();

    }
    public function setJobState()
    {
        $request=\Request::all();
        $v=\Validator::make($request,$this->notification_state);
        if ($v->fails())
        {
             $this->abortCode(404,"参数错误");
        }
        $sendJobId=$request['send_job_id'];
        $notificationJobModel=new Notificationjob;
        $updateData=[
            'state' => $state
        ];
        $notificationJobModel->setState($updateData,$sendJobId);
        return $this->r();
    }

    public function setJobData()
    {
        $request=\Request::all();
        $v=\Validator::make($request,$this->notification_data);
        if ($v->fails())
        {
             $this->abortCode(404,"参数错误");
        }
        $sendJobId=$request['send_job_id'];
        $notificationJobModel->setState($updateData,$sendJobId);
        return $this->r();
    }

}
