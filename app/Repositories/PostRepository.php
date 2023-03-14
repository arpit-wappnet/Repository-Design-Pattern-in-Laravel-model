<?php

namespace App\Repositories;

use App\Interfaces\PostInterface;
use App\Models\Post;

class PostRepository implements PostInterface
{

    /**
     * Function : Get All Posts
     * @param NA
     * @return posts
     */
    public function getAllPosts()
    {
        return Post::all();
    }

    /**
     * Function : Create Post
     *
     * @param [type] $request
     * @return post
     */
    public function createPost($request)
    {
        return Post::create([
            'title' => $request->title,
            'content' => $request->content,
        ]);
    }

    /**
     * Function : Get Post By Id
     * @param [type] $id
     * @return post
     */
    public function getPostById($id)
    {
        return Post::find($id);
    }

    /**
     * Function : Update Post
     *
     * @param [type] $request
     * @param [type] $id
     * @return post
     */
    public function updatePost($request, $id)
    {
        $post = Post::find($id);
        if ($post) {
            $post['title'] = $request->title;
            $post['content'] = $request->content;
            $post->save();
            return $post;
        }
    }

    /**
     * Function : Delete Post
     * @param [type] $id
     * @return void
     */
    public function deletePost($id)
    {
        $post = Post::find($id);
        if ($post) {
            return $post->delete();
        }
    }
}
