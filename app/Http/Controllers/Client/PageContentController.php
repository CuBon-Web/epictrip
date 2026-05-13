<?php

namespace App\Http\Controllers\Client;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\models\PageContent;
use Session;

class PageContentController extends Controller
{
    public function detail($slug)
    {
    	$language_current = Session::get('locale');
    	$root = PageContent::where('slug', $slug)->first(['id', 'quiz_id']);
    	if (! $root) {
    		abort(404);
    	}
    	$data['pagecontentdetail'] = PageContent::where([
    		'quiz_id' => $root->quiz_id,
    		'language' => $language_current,
    	])->first()
    		?? PageContent::where('quiz_id', $root->quiz_id)->first();
    	if (! $data['pagecontentdetail']) {
    		abort(404);
    	}
    	return view('pageContent', $data);
    }
}
