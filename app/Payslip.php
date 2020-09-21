<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payslip extends Model
{
	/**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'payslips';
    
    public function employee()
    {
    	return $this->belongsTo('App\Employee', 'user_id');
    }
}
