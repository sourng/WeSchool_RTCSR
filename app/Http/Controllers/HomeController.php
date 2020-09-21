<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App;

class HomeController extends Controller
{
    //
    public function lang($locale)
    {
        // echo "Hello world";
        App::setLocale($locale);
        session()->put('locale', $locale);
        // $locale=app()->getLocale();
        // echo "Hello". $locale;

        return redirect()->back();
    }
}
