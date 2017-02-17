<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Pipeline;
use App\Tools\Page;

class PipelineController extends Controller
{	

	public function __construct(Page $page)
	{
		$this->page=$page;
		$this->pipeline=new Pipeline();
	}

	//更新队列
	
	private $verify_upate=[
		'pipeline_id'					=>'bail|required|numeric',
		'pipeline_name'					=>'bail|required|numeric',
		'pipeline_description'			=>'bail|required|numeric',
		'output_type'					=>'bail|required|numeric',
		'input_bucket'					=>'bail|required|numeric',
		'input_bucket_access_key_id'	=>'bail|required|numeric',
		'input_bucket_access_key_secret'=>'bail|required|numeric',
		'output_bucket'					=>'bail|required|numeric',
		'output_bucket_access_key_id'	=>'bail|required|numeric',
		'output_bucket_access_key_secret'					=>'bail|required|numeric',
		'pipeline_capacity'					=>'bail|required|numeric',
		'pipeline_complicating'					=>'bail|required|numeric',
		'state'					=>'bail|required|numeric',
		'pipeline_priority'					=>'bail|required|numeric',
	];
	//添加队列
	private $verify_save=[
			'pipeline_name'=>"bail|required",  
			'pipeline_description'=>"bail|required",
			'output_type'=>"bail|required",
			'input_bucket'=>"bail|required",
			'input_bucket_access_key_id'=>"bail|required",
			'input_bucket_access_key_secret'=>"bail|required",
			'output_bucket'	=>"bail|required",
			'output_bucket_access_key_id'=>"bail|required",
			'output_bucket_access_key_secret'=>"bail|required",
			'pipeline_capacity'=>"bail|required",
			'pipeline_complicating'=>"bail|required",
			'state'=>"bail|required",	
			'pipeline_priority'=>"bail|required"
	];
	//保存队列
    public function save()
    {
       $request=\Request::all();
       $v=\Validator::make($request,$this->verify_save);
       if ($v->fails()) 
       {
             $this->abortCode(404,"参数错误");
       }
       $ID=Pipeline::insertGetId($request);
       if (!$ID)
       {
       		$this->abortCode(404,"插入数据失败");
       }
       return $this->r();
    }
    //列表
    public function index()
    {
    	$pipeline_id=\Request::all();
    	if (empty($pipeline_id['pipeline_id']))
    	{
    		$this->__getList();
    	} else 
    	{
    		$this->__getOne();
    	}
    }
    private function __getList()
    {
    	$list=$this->get_one_page_data($this->page,$this->pipeline,'adminList','adminLength',[]);
    	return $this->r(['page'=>$this->page->getPage(),'list'=>$list]);
    }
    private function __getOne()
    {

    }


}
