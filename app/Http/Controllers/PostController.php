<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Post;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Service\PostService;
use App\Service\PermissionService;

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
     * @param Request $request
     * @param PostService $postService
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request, PostService $postService)
    {
        $this->validate($request, [
            'title' => 'required',
            'text' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg'
        ]);

        $postId = $postService->createPost($request);

        $request->session()->flash('success', 'New post added - successful!');

        return redirect()->route('post.show', $postId);
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
        return view('post.show')->withPost($post);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param $id
     * @param PermissionService $permissionService
     * @return mixed
     */
    public function edit($id, PermissionService $permissionService)
    {
        $post = Post::find($id);
        if (!$permissionService->canEditAndDeletePost($post)) {
            return redirect('/');
        }

        return view('post.edit_post')->withPost($post);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param $id
     * @param PostService $postService
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id, PostService $postService)
    {
        $this->validate($request, [
            'title' => 'required',
            'text' => 'required'
        ]);

        $postId = $postService->updatePost($request, $id);

        $request->session()->flash('success', 'Edit post - successful!');

        return redirect()->route('post.show', $postId);
    }

    /**
     * Delete post and image
     *
     * @param $id
     * @param PostService $service
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id, PostService $service, PermissionService $permissionService)
    {
        $post = Post::find($id);
        if (!$permissionService->canEditAndDeletePost($post)) {
            return redirect('/');
        }
        $imageName = $post->img;
        $post->delete();
        $service->deleteImage($imageName);

        return redirect()->route('home');
    }

    /**
     * Create comment
     *
     * @param Request $request
     * @param PostService $postService
     * @return \Illuminate\Http\JsonResponse
     */
    public function createComment(Request $request, PostService $postService)
    {
        $comment = $postService->createComments($request);

        return response()->json($comment);
    }

    /**
     * Delete comment
     *
     * @param $id
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function deleteComment($id)
    {
        $comment = Comment::find($id);
        $comment->delete();

        return response('success', 200);
    }
}
