<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
	/**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'employees';

    public function user()
    {
    	return $this->belongsTo('App\User');
    }

    public function department()
    {
    	return $this->belongsTo('App\Department');
    }

    public function designation()
    {
    	return $this->belongsTo('App\Designation');
    }
}
