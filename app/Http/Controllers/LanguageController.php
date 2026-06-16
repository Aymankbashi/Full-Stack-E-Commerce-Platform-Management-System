<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Redirect;

class LanguageController extends Controller
{
    public function switch($locale)
    {
        if (!in_array($locale, ['ar', 'en'])) {
            $locale = 'ar';
        }
        session(['locale' => $locale]);
        App::setLocale($locale);
        $previous = url()->previous();
        return Redirect::to($previous);
    }
}
