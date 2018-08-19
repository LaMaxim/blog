<?php

namespace App\Service;

use App\Post;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class PostService
{
    /**
     * Delete file image
     *
     * @param $imageName
     */
    public function deleteImage($imageName)
    {
        $pathImage = base_path() . '/public/post-images/' . $imageName;
        unlink($pathImage);
    }

    /**
     * Create new post
     *
     * @param Request $request
     * @return mixed
     */
    public function createPost (Request $request)
    {
        $slug = str_random(5);

        $post = new Post();
        $post->title = $request->title;
        $post->slug = $slug;
        $post->text = $request->text;
        $post->save();
        $post->users()->attach(Auth::user()->id);

        $imageName = $post->id . '.' . $request->file('image')->getClientOriginalExtension();
        $request->file('image')->move(base_path() . '/public/post-images/', $imageName);
        chmod(base_path() . '/public/post-images/', 0666);

        $post->img = $imageName;
        $post->save();

        return $post->id;
    }

    /**
     * Update data post
     *
     * @param Request $request
     * @param $id
     * @return mixed
     */
    public function updatePost (Request $request, $id)
    {
        $post = Post::find($id);
        $post->title = $request->title;
        $post->text = $request->text;
        $post->save();
        if ($request->file('image')) {
            $this->deleteImage($post->img);
            $imageName = $post->id . '.' . $request->file('image')->getClientOriginalExtension();
            $request->file('image')->move(base_path() . '/public/post-images/', $imageName);
            chmod(base_path() . '/public/post-images/', 0666);

            $post->img = $imageName;
            $post->save();
        }

        return $post->id;
    }
}
