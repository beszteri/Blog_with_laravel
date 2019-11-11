<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PagesController extends Controller
{
    public function index(){
        $title = 'Welcome';
        /*kétféleképpen lehet átadni egy változót a view-nek, így:
        return view('pages.index', compact('title'));
        vagy így:*/
        return view('pages.index')->with('title', $title);
    }

    public function about(){
        $title = 'About us';
        return view('pages.about')->with('title', $title);
    }

    public function services(){
        $data = array(
            'title' => 'services',
            'services' => ['web design', 'programming']
        );
        return view('pages.services')->with($data);
    }
}
