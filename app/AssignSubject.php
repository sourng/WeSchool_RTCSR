<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class AssignSubject extends Model
{
    public static function getSubject($class,$section){
		$class = sql_escape($class);
		$section = sql_escape($section);
		$subjects = DB::select("SELECT subjects.*, assign_subjects.*, subjects.id as s_id,assign_subjects.id as a_id 
		FROM subjects LEFT JOIN assign_subjects ON subjects.id=assign_subjects.subject_id AND assign_subjects.section_id='$section' 
		WHERE subjects.class_id='$class'");
		return $subjects;
		 
	}
}
