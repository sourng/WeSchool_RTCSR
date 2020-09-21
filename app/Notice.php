<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notice extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'notices';
	
	public function user_type()
    {
        return $this->hasMany('App\UserNotice');
    }
}