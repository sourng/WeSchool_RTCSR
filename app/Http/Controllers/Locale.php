<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Locale extends Controller
{
    //
    public function index($lang){
         return view('locale');
        }
}
