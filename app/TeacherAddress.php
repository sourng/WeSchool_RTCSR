<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TeacherAddress extends Model
{
    //
    protected $table = 'teacher_address';

    public function teacher(){
        return $this->hasOne('App\Teacher');
    }
}
