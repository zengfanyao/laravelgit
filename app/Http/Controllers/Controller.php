<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;


class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public  $r=[];
    public  $msg;
    public  $code;
    public  $state;
    public  $method;
    public  $request_id;
  
    public function __construct()
    {
    	
    	$this->_r_init();
    }


    public function abortCode($code='404',$message='')
    {
        abort($code,$message);
    } 

    public function r($r=array(),$status='200')
    {
        $this->_r_init();
    	if (is_numeric($r))
    	{
    		$status=$r;
    	}
    	$r= is_array($r) ? $r : array();
    	if (isset($r['sysdata']) && is_array($r['sysdata']))
    	{
    		$r['sysdata'] =array_merge($this->r['sysdata'],$r['sysdata']);
    	}else{

    		$r['sysdata']=$this->r['sysdata'];
    	}
    	

    	$this->r=&$r;
    	$r['code']=(int)$status;
    	$r['error_id']=empty($r['error_id']) ? "OK" : $r['error_id'];
    	if (empty($r['state'])||$r['state']===null) 
    	{
			$r['state'] = ($status>=200&&$status<300) ;
		}
		if (function_exists("set_status_header"))
		{
			set_status_header($r['code'],$r['error_id']);
		} else
		{
			try{
				if(strpos(PHP_SAPI,'cgi') ===0 )
				{
					header('Status: '.$r['code']. ' '. $r['error_id'],TRUE);
				}else {

				}

			}catch(Exception $e)
			{
				$server_protocol=isset($_SERVER['SERVER_PROTOCOL']) ? $_SERVER['SERVER_PROTOCOL'] : 'HTTP/1.1';
				header($server_protocol.' '.$r['code'].' '.$r['error_id'], TRUE, $r['code']);
				unset($server_protocol);
			}
		}
		$r = json_encode($r,JSON_UNESCAPED_UNICODE);
		return response($r,$status)->header('Content-Type','application/json;charset=utf-8');
    }
    private  function _r_init()
    {
    	$this->r=[
    			'sysdata'=>[
				//请求id
				'request_id'=>'',
				//强制刷新浏览器
				'reload'=>false,
				//强制跳转到以下url,如果url返回的不是空字符串就跳转
				'url'=>'',
				//uid默认是0
				'uid'=>'0',
				//是否已经登陆
				'is_login'=>false,
				//跳转到登陆
				'to_login'=>false,
				//签名是否通过
				'is_sign'=>false,
				//服务器签名返回
				'session_sign'=>''
			],
			//状态
			'state'=>null,
			//错误识别码
			'error_id'=>'OK',
			//消息
			'msg'=>'',
			//代码
			'code'=>500
    		];
    	$this->r['sysdata']['request_id']=&$this->request_id;
    	$this->r['msg']=&$this->msg;
    	$this->r['code']=&$this->code;
    	$this->r['state']=&$this->state;


    }
    protected function get_one_page_data(&$pageInfo,&$dataClass,$listFunc, $lengFunc = null, array $params = null)
    {
    	
        $page=\Request::all();
        $page_now = isset($page['page_now']) ? $page['page_now'] : 1;
        $page_size = isset($page['page_size']) ? $page['page_size'] : 15;
        $psize = !empty($page_size) && intval($page_size) > 0  ? intval($page_size) : 15;
        $pn = !empty($page_now) && intval($page_now) > 0 ? intval($page_now) : 1;
        $rt = false;
        if (null == $lengFunc){
            $lengFunc = $listFunc . "Length";
        }
        $dataSize = call_user_func_array([$dataClass, $lengFunc], (array) $params);
        if ($dataSize > 0) {
            $begin = ($pn - 1) * $psize; //从第N笔开始检索
            $size=$psize;

            $paramss=[$begin,$size]; //开始数,结束数
            if ($params!=null){
                $params=array_merge($paramss,$params);
            }
            else{
                $params=$paramss;
            }
            $rt = call_user_func_array([$dataClass,$listFunc], (array) $params);
            if (!$rt) {
                throw new RJsonErrorException('分页错误','PAGE_ERROR');
            }
        } else {
            $rt=[];
        }
        $page=[
            'count' => $dataSize,
            'now' => $pn,
            'size' => $psize,
           
        ];
        $pageInfo->init($page);
        return $rt;

    }
}
