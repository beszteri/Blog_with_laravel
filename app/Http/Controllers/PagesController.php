<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PagesController extends Controller
{
    /* public function index(){
         $title = 'Welcome';
         kétféleképpen lehet átadni egy változót a view-nek, így:
         return view('pages.index', compact('title'));
         vagy így:
         return view('pages.index')->with('title', $title);
     }*/

    public function about()
    {
        $data = array(
            'title' => 'About this App',
            'about' => 'This is my first Blog webapp built with laravel 6'
        );
        return view('pages.about')->with($data);
    }

    /* public function services(){
         $data = array(
             'title' => 'services',
             'services' => ['web design', 'programming']
         );
         return view('pages.services')->with($data);
     }*/
}
