<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\HostelCategory;

class UniqueStandard implements Rule
{
    protected $hostel_id;
    protected $standard;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($hostel_id,$standard)
    {
        $this->hostel_id = $hostel_id;
        $this->standard = $standard;
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
        $standard = HostelCategory::where(['standard'=>$this->standard,'hostel_id'=>$this->hostel_id])->value('standard');
        if($standard != ''){
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
        return 'This standard already exists for the hostel.';
    }
}
