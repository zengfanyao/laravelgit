<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Preset extends Model
{
    public  $table = 'hz_preset';   
   	public $primaryKey = 'preset_id';
    public $timestamps = false;

    public function getOne($preset_id)
    {
    	return $this->where('preset_id',$preset_id)
    			->select('preset_id','preset_name',
    				'preset_name_description',
    				'preset_container','clip','clip_start_time_in_second',
    				'clip_start_time_duration_in_second','video_codec',
    				'video_profile','video_bit_rate_in_bps','video_max_frame_rate','video_max_width_in_pixel',
    				'video_max_height_in_pixel','video_sizing_policy','audio_codec','audio_sample_rate_in_hz','audio_bit_rate_in_bps','audio_channels')
    			->first();
    }
}
