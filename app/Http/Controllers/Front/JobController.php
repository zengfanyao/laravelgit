<?php

namespace App\Http\Controllers\Front;

use DB;
use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\FrontController;
use Illuminate\Support\Facades\Input;
use App\Models\Job;



class JobController extends FrontController
{

    //验证条件
    private $job_len = [
            'len' => 'required|numeric'
        ];

    private $set_state = [
            'job_id' => 'required|numeric',
            'state'  =>'required|state'
        ];

    private $add_lock = [
            'job_id'=> 'required|numeric'
        ];
    //数据库对象
    private $job;


    public function __construct()
    {
        parent::__construct();
        $this->job=new Job;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       $request=\Request::all();
       $v=\Validator::make($request,$this->job_len);
       if ($v->fails()) 
       {
             $this->abortCode(404,"参数错误");
       }
       $jobLen=$request['len'];
       $result=$this->job->getJobLen($jobLen);
       return $this->r(['list'=>$result]);  
    }
    //获取正在转码的个数
    public function tc()
    {
        $res=$this->job->getTcLen();
        $data=['count'=>$res];
        return $this->r(['data'=>$data]);
    }
    //修改任务状态
    public function state()
    {
        $request=\Request::all();
        $v=\Validator::make($request,$this->set_state);
        if ($v->fails()) 
        {
             $this->abortCode(404,"参数错误");
        }
        $this->job->setState($request);
        return $this->r();
    }
    //加锁
    public function lock()
    {
        $request=\Request::all();
        $v=\Validator::make($request,$this->add_lock);
        if ($v->fails()) 
        {
             $this->abortCode(404,"加锁出错");
        }
        $jobId=$request['job_id'];
       
        try {
           DB::beginTransaction();

            $r=$this->job->getOne($jobId);
            if (empty($r)) 
            {
                throw new Exception("Error Processing Request", 1);
            }
            if ((int)$r->state!==0)
            {
                throw new Exception("Error Processing Request", 1);
                
            }

            //锁定任务先
            $update_data=[
                    'job_id'=>$jobId,
                    'state' =>2
                ];
            $this->job->setState($update_data);
        } catch (Exception $e) {
            DB::rollBack();
            $this->abortCode(404,"操作失败");
        }
        DB::commit();
       return  $this->r();
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
