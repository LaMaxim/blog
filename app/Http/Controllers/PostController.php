<?php

namespace App\Http\Controllers;

use App\Post;
use App\User;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;
use App\Service\PostService;

class PostController extends Controller
{

    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('post.create_post');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'text' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg'
        ]);

        $slug = str_random(5);

        $post = new Post();
        $post->title = $request->title;
        $post->slug = $slug;
        $post->text = $request->text;
        $post->save();
        $post->users()->attach(Auth::user()->id);

        $imageName = $post->id . '.' . $request->file('image')->getClientOriginalExtension();
        $request->file('image')->move(base_path() . '/public/post-images/', $imageName);

        $request->session()->flash('success', 'New post added - successful!');

        return redirect()->route('post.show', $post->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Post::find($id);
        $user = Auth::user();
        $userRole = $user->roles->first()->name;
        return view('post.show', ['userRole' => $userRole])->withPost($post);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = Post::find($id);
        $user = Auth::user();

        if ($post->users()->first()->id != $user->id) {
            return redirect('/');
        }

        return view('post.edit_post')->withPost($post);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $slug = str_random(5);

        $post = Post::find($id);
        $post->title = $request->title;
        $post->slug = $slug;
        $post->text = $request->text;
        $post->save();

        $request->session()->flash('success', 'Edit post - successful!');

        return redirect()->route('post.show', $post->id);
    }

    /**
     * Delete post and image
     *
     * @param $id
     * @param PostService $service
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id, PostService $service)
    {
        $post = Post::find($id);
        $post->delete();
        $service->deleteImage(base_path() . '/public/post-images/', $id);

        return redirect()->route('home');
    }

    /**
     * @param array $allow
     * @param Post $post
     * @return bool
     */
    public function allowEditElements($allow = [], Post $post) {
        $user = Auth::user();
        $userRole = $user->roles->first()->name;

        if (empty($allow)) {
            return false;
        }

        if (in_array('owner', $allow) && ($user->id == $post->users()->first()->id)) {
            return true;
        }

        return in_array($userRole, $allow);
    }
}
