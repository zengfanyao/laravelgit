<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


class FrontController extends Controller
{
    public function __construct()
    {
    	parent::__construct();
    }

    public function abortCode($code='404',$message='')
    {
    	abort($code,$message);
    }
    
}
