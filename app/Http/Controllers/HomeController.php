<?php

namespace App\Http\Controllers;

use App\Analytics;
use Illuminate\Http\Request;

use TCG\Voyager\Facades\Voyager;

class HomeController extends Controller
{
    public function index(){

    	//$posts = Voyager::model('Post')->all();

        $title = "";

    	return view('site.home',compact('title'));
    }

    public function show($slug)
    {
        $post = Voyager::model('Post')->where('slug',$slug)->where('status','PUBLISHED')->first();
        if(isset($post))
            $object = 'post';
            $object_id = $post->id;
            $action = 'view';
            $description = $post->slug;

            Analytics::saveUserAnalytics($object, $object_id, $action, $description);

            return view('site.blog_detail',compact('post'));

        return redirect()->back();
    }
}
