<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class ClassRoutine extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'class_routines';
	
	public static function RoutineList($class_id = ""){
		$class_id  = sql_escape($class_id);
		$filter = $class_id !="" ? "WHERE classes.id='$class_id'" : "";
		
		$routine_list = DB::select("SELECT classes.class_name,sections.section_name, classes.id as c_id, sections.id as s_id, class_routines.id as r_id 
		FROM classes INNER JOIN sections ON classes.id=sections.class_id LEFT JOIN class_routines ON sections.id=class_routines.section_id $filter GROUP by sections.id");
		return $routine_list;	 
	}
	
	public static function getRoutine($class="",$section=""){
		$class = sql_escape($class);
		$section = sql_escape($section);
		
		//$subjects = DB::select("SELECT subject.*, class_routines.* FROM (SELECT class_days.id as class_day_id,class_days.day as class_day, subjects.id as s_id,subjects.subject_name 
		//FROM class_days JOIN subjects WHERE class_days.is_active=1 AND subjects.class_id='$class') as subject LEFT JOIN class_routines ON subject.s_id=class_routines.subject_id 
		//AND subject.class_day=class_routines.day AND class_routines.section_id='$section' ORDER BY subject.class_day_id, subject.s_id");
		
		$subjects = DB::select("SELECT routine.*,teachers.name as teacher FROM (SELECT subject.*, class_routines.* FROM (SELECT class_days.id as class_day_id,class_days.day as class_day, subjects.id as s_id,subjects.subject_name 
		FROM class_days JOIN subjects WHERE class_days.is_active=1 AND subjects.class_id='$class') as subject LEFT JOIN class_routines ON subject.s_id=class_routines.subject_id AND subject.class_day=class_routines.day AND 
		class_routines.section_id='$section') as routine,assign_subjects,teachers WHERE assign_subjects.section_id='$section' AND routine.s_id=assign_subjects.subject_id AND assign_subjects.teacher_id=teachers.id 
		ORDER BY routine.class_day_id, routine.s_id");
		
		$routines = array();

		foreach($subjects  as $subject){			   
		    $routines[$subject->class_day][$subject->s_id] = $subject;			
		}

       return $routines;
	}
	
	public static function getRoutineView($class="",$section=""){
		$class = sql_escape($class);
		$section = sql_escape($section);
		
		//$subjects = DB::select("SELECT subject.*, class_routines.* FROM (SELECT class_days.id as class_day_id,class_days.day as class_day, subjects.id as s_id,subjects.subject_name 
		//FROM class_days JOIN subjects WHERE class_days.is_active=1 AND subjects.class_id='$class') as subject LEFT JOIN class_routines ON subject.s_id=class_routines.subject_id 
		//AND subject.class_day=class_routines.day AND class_routines.section_id='$section' ORDER BY subject.class_day_id, subject.s_id");
		
		$subjects = DB::select("SELECT routine.*,teachers.name as teacher FROM (SELECT subject.*, class_routines.* FROM (SELECT class_days.id as class_day_id,class_days.day as class_day, subjects.id as s_id,subjects.subject_name 
		FROM class_days JOIN subjects WHERE class_days.is_active=1 AND subjects.class_id='$class') as subject LEFT JOIN class_routines ON subject.s_id=class_routines.subject_id AND subject.class_day=class_routines.day AND 
		class_routines.section_id='$section') as routine,assign_subjects,teachers WHERE assign_subjects.section_id='$section' AND routine.s_id=assign_subjects.subject_id AND assign_subjects.teacher_id=teachers.id 
		ORDER BY routine.class_day_id, routine.start_time");
		
		$routines = array();

		foreach($subjects  as $subject){			   
		    $routines[$subject->class_day][$subject->s_id] = $subject;			
		}

       return $routines;
	}
	
	public static function getTeacherRoutine($teacher_id=""){
		$teacher_id = sql_escape($teacher_id);

		$subjects = DB::select("SELECT subjects.subject_name,teachers.name,class_routines.*,classes.class_name,sections.section_name 
		FROM assign_subjects JOIN subjects ON assign_subjects.subject_id=subjects.id 
		JOIN teachers ON assign_subjects.teacher_id=teachers.id JOIN class_routines 
		ON assign_subjects.subject_id=class_routines.subject_id AND class_routines.section_id=assign_subjects.section_id JOIN sections ON class_routines.section_id=sections.id JOIN classes ON sections.class_id=classes.id
		WHERE assign_subjects.teacher_id='$teacher_id' ORDER BY class_routines.start_time");
		
		$routines = array();

		foreach($subjects  as $subject){			   
		    $routines[$subject->day][$subject->subject_id] = $subject;			
		}

       return $routines;
	}
	
}