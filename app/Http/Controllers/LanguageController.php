<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
class LanguageController extends Controller
{
    public function index($lang){
        $supportedLanguages = ['en-US', 'es-ES'];
        if (isset($lang) && in_array($lang, $supportedLanguages, true)) {
            session()->put('localelang', $lang);
            session()->put('locale', $lang);
        }
        return redirect()->back();
    }
}
