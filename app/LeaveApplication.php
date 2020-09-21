<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LeaveApplication extends Model
{
	/**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'leave_applications';

    public function leave_type()
    {
    	return $this->belongsTo('App\LeaveType');
    }

    public function employee()
    {
    	return $this->belongsTo('App\Employee', 'user_id');
    }
}
