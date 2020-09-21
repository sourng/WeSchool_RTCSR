<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MarkDetails extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'mark_details';
	protected $fillable = array('mark_id','mark_type', 'mark_value');
}