<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    //
    public function user() { 
        return $this->hasOne('App\User','id','user_id'); 
    }

    public function qualifications()
    {
        return $this->hasMany('App\TeacherQualifications');
    }
    public function working()
    {
        return $this->hasMany('App\TeacherWorkingHistory');
    }
    public function speak()
    {
        return $this->hasMany('App\TeacherSpeak');
    }
    public function skill()
    {
        return $this->hasMany('App\TeacherSkill');
    }
    
    

}
