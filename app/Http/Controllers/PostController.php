<?php

namespace App\Http\Controllers;

use App\Interfaces\PostInterface;
use Illuminate\Http\Request;
use SebastianBergmann\RecursionContext\Exception;

class PostController extends Controller
{
    private $postInterface;

    public function __construct(PostInterface $postInterface)
    {
        $this->postInterface = $postInterface;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = $this->postInterface->getAllPosts();
        return view('index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $post = $this->postInterface->createPost($request);
            if ($post) {
                return redirect()->route('posts.index')->with('success', 'Success! post is created');
            } else {
                return back()->with('failed', 'Failed! unable to create post');
            }
        } catch (Exception $e) {
            return back()->with('failed', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $post = $this->postInterface->getPostById($id);
            if ($post) {
                $isView = true;
                return view('create', compact('post', 'isView'));
            } else {
                return redirect('posts.index')->with('failed', 'Failed! no post found');
            }
        } catch (Exception $e) {
            return redirect('posts.index')->with('failed', $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try {
            $post = $this->postInterface->getPostById($id);
            if ($post) {
                $isEdit = true;
                return view('create', compact('post', 'isEdit'));
            } else {
                return redirect('posts.index')->with('failed', 'Failed! no post found');
            }
        } catch (Exception $e) {
            return redirect('posts.index')->with('failed', $e->getMessage());
        }
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
        try {
            $post = $this->postInterface->updatePost($request, $id);
            if ($post) {
                return redirect()->route('posts.index')->with('success', 'Success! post is updated');
            } else {
                return back()->with('failed', 'Failed! unable to update post');
            }
        } catch (Exception $e) {
            return back()->with('failed', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $post = $this->postInterface->deletePost($id);
            if ($post) {
                return redirect()->route('posts.index')->with('success', 'Success! post is deleted');
            } else {
                return back()->with('failed', 'Failed! unable to delete post');
            }
        } catch (Exception $e) {
            return back()->with('failed', $e->getMessage());
        }
    }
}
