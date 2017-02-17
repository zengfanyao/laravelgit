<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Job;

class JobController extends Controller
{


	 private $job_len= [
            'pipeline_id' => 'bail|required',
            'input_file' => 'bail|required',
            'preset_id' => 'bail|required',
            'output_file' => 'bail|required',
            'len' => 'bail|required',
        ];

	//新建转码任务
    public function index()
    {

    }
}
