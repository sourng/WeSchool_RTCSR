<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'expenses';

    public function employee()
    {
    	return $this->belongsTo('App\Employee', 'expense_by');
    }
}
