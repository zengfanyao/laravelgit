<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\FrontController;
use App\Models\Preset;

//模板
class PresetController extends FrontController
{
	private $preset_con = [
        'preset_id' => 'required|numeric'
    ];

	private $preset;
    public function __construct()
    {
    	parent::__construct();
    	$this->preset=new Preset;

    }

    public function index()
    {
    	$request=\Request::all();
    	$v=\Validator::make($request,$this->preset_con);
    	if ($v->fails())
    	{
    		 $this->abortCode(404,"参数错误");
    	}
    	$preset_id=$request['preset_id'];
    	$result=$this->preset->getOne($preset_id);
    	return $this->r(['data'=>$result]);
    }
}
