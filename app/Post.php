<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'posts';
	
	public function content()
    {
        return $this->hasMany('App\PostContent');
    }
	
	public function author()
    {
        return $this->hasOne('App\User', 'id', 'author_id');
    }
	
	public function category()
    {
        return $this->hasOne('App\PostCategory', 'id', 'category_id');
    }
}