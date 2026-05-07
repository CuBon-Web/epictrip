<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Session;

class LanguageController extends Controller
{
    public function index(Request $request){
        $supportedLanguages = ['en-US', 'es-ES'];
        if (isset($request->code) && in_array($request->code, $supportedLanguages, true)) {
            Session::put('locale', $request->code);
            Session::put('localelang', $request->code);
        }
        return redirect()->back();
    }
}
