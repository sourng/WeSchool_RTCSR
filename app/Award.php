<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Award extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
	protected $table = 'awards';
	
    public function award_type()
    {
    	return $this->belongsTo('App\TypesOfAward', 'types_of_award_id');
    }

    public function employee()
    {
        return $this->belongsTo('App\Employee', 'user_id');
    }
}
