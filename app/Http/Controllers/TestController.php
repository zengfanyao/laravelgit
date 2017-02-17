<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Tools\Page;
use App\Models\Job;

class TestController extends Controller
{

	public function __construct()
	{
		$this->page=new Page;
		$this->model=new Job;
	}

    public function index()
    {
    	var_dump(11111);
    }

    public function page()
    {
        
    	
    	
    }
}
?>
