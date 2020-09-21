<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TeacherSkill extends Model
{
    //
    // return $this->hasMany('App\Models\Comment', 'foreign_key');
    public function teacher(){
        return $this->belongsTo('App\Teacher');
    }
}
