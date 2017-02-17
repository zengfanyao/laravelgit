<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\FrontController;
use App\Models\Pipeline;

//模板
class PipelineController extends FrontController
{

	public $pipeline;

    //验证规则
	private  $index_con=[
			'pipeline_id' =>' required|numeric'
		];
    private $add_con = [
            'pipeline_id' =>' required|numeric'
        ];
    private $cancel_con = [
            'pipeline_id' =>' required|numeric'
        ];



    
    public function __construct()
    {
    	parent::__construct();
        $this->pipeline=new Pipeline;
    }

    //获取模板信息
    public function index()
    {
    	$request=\Request::all();
        $v=\Validator::make($request,$this->index_con);
        if ($v->fails()) 
        {
            $this->abortCode(404,"参数错误");
        }

        $pipelineData= $this->pipeline->getOne($request['pipeline_id']);
        if (empty($pipelineData))
        {
            $this->abortCode(404,"队列不可用||或者为空");
        }
        return $this->r(['data'=>$pipelineData]);

    }

    public function add()
    {

        $request=\Request::all();
        $v=\Validator::make($request,$this->add_con);
        if ($v->fails())
        {
            $this->abortCode(404,"参数错误");
        }
        $pipeline=$request['pipeline_id'];
        $affected=$this->pipeline->addNum($pipeline);
        if (is_numeric($affected) && $affected==0)
        {
            $this->abortCode(404,"更新失败");
        }
        return $this->r();

    }
    public function cancel()
    {
        $request=\Request::all();
        $v=\Validator::make($request,$this->cancel_con);
        if ($v->fails())
        {
            $this->abortCode(404,"参数错误");
        }
        $pipelineId=$request['pipeline_id'];
        $column='pipeline_complicating_now';
        $pipelineData=$this->pipeline->getInfoByPipelineId($pipelineId,$column);
    

        if ($pipelineData->pipeline_complicating_now > 0)
        {
             $affected=$this->pipeline->cancelNum($pipelineId);
            if (is_numeric($affected) && $affected==0)
            {
                $this->abortCode(404,"更新失败");
            }
        }
        return $this->r();
    }


    

}
