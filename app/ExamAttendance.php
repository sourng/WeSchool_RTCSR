<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ExamAttendance extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'exam_attendances';
	
	protected $fillable = array('exam_id','subject_id', 'student_id', 'class_id', 'section_id', 'date', 'attendance');

}