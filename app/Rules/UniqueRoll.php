<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use DB;

class UniqueRoll implements Rule
{
	
	protected $section_id;
	protected $student_id;
	protected $roll;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($section_id,$roll,$student_id="")
    {
        $this->section_id = $section_id;
        $this->roll = $roll;
		if($student_id != ""){
		   $this->student_id = $student_id;
		}
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
		$session_id = get_option('academic_year');	
        $roll = DB::table('student_sessions')
		        ->where('session_id', $session_id)
		        ->where('section_id', $this->section_id)
		        ->where('roll', $this->roll)
		        ->where('student_id',"!=", $this->student_id)
				->value('roll');
		if($roll !=""){
			return false;
		}		
		return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
		return 'The :attribute must unique for this section.';
    }
}
