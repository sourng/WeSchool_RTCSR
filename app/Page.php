<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'pages';
	
	public function content()
    {
        return $this->hasMany('App\PageContent');
    }
	
	public function author()
    {
        return $this->hasOne('App\User', 'id', 'author_id');
    }

}