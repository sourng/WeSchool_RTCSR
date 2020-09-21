<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TeacherQualifications extends Model
{
    //
    // protected $fillable ="teacher_qualifications";
    protected $table = 'teacher_qualifications';

    public function teacher(){
        return $this->belongsTo('App\Teacher');
    }
}
