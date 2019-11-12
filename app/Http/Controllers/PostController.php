<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //$posts = Post::all();
        //vagy :
        //$return Post::where('title', 'Post Two')->get();
        //$posts = Post::orderBy('title', 'desc')->get();
        //limitálhatjuk a találatot:
        //$posts = Post::orderBy('title', 'desc')->take(1)->get();
        // vagy
        //lapozáshoz:
        $posts = Post::orderBy('created_at', 'desc')->paginate(10);
        return view('posts.index')->with('posts', $posts);

        //ha nem orm-et akarunk használni akkor:
        //$posts = DB::select('select * from posts');
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'show']]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //csak ha ki van töltve a form akkor lép tovább
        $this->validate($request, [
            'title' => 'required',
            'body' => 'required',
            'cover_image' => 'image|nullable|max:1999'
        ]);

        //file feltöltés kezelése
        if ($request->hasFile('cover_image')) {
            //fájlnév és kiterjesztés:
            $filenameWithExt = $request->file('cover_image')->getClientOriginalName();
            //csak fájlnév:
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            //csak kiterjesztés:
            $extension = $request->file('cover_image')->getClientOriginalExtension();
            //fájlnév mentéshez
            $fileNameToStore = $filename . '_' . time() . '.' . $extension;
            //feltöltés
            $path = $request->file('cover_image')->storeAs('public/cover_images', $fileNameToStore);
        } else {
            $fileNameToStore = 'noimage.jpg';
        }


        $post = new Post();
        $post->title = $request->input('title');
        $post->body = $request->input('body');
        $post->user_id = auth()->user()->id;
        $post->cover_image = $fileNameToStore;
        $post->save();
        return redirect('/posts')->with('success', 'Post Created');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Post::find($id);
        return view('posts.show')->with('post', $post);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = Post::find($id);
        if (auth()->user()->id !== $post->user_id) {
            return redirect('/posts')->with('error', 'Unauthorized Page');
        }
        return view('posts.edit')->with('post', $post);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'title' => 'required',
            'body' => 'required',
            'cover_image' => 'image|nullable|max:1999'
        ]);

        //file feltöltés kezelése
        if ($request->hasFile('cover_image')) {
            //fájlnév és kiterjesztés:
            $filenameWithExt = $request->file('cover_image')->getClientOriginalName();
            //csak fájlnév:
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            //csak kiterjesztés:
            $extension = $request->file('cover_image')->getClientOriginalExtension();
            //fájlnév mentéshez
            $fileNameToStore = $filename . '_' . time() . '.' . $extension;
            //feltöltés
            $path = $request->file('cover_image')->storeAs('public/cover_images', $fileNameToStore);
        }
        $post = Post::find($id);
        $post->title = $request->input('title');
        $post->body = $request->input('body');
        if ($request->hasFile('cover_image')) {
            $post->cover_image = $fileNameToStore ?? null;
        }
        $post->save();
        return redirect('/posts')->with('success', 'Post Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::find($id);
        if (auth()->user()->id !== $post->user_id) {
            return redirect('/posts')->with('error', 'Unauthorized Page');
        }
        if ($post->cover_image != 'noimage.jpg') {
            Storage::delete('public/cover_images/' . $post->cover_image);
        }
        $post->delete();
        return redirect('/posts')->with('success', 'Post Deleted');
    }
}
