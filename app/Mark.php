<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Mark extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'marks';
	protected $fillable = array('exam_id','subject_id', 'student_id', 'class_id', 'section_id');
}