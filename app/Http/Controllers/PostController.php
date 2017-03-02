<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Post;

use App\Category;

class PostController extends Controller
{
    public function getBlogIndex()
    {
        // fetch Post and Paginate
        $posts = Post::paginate(5);
        foreach ($posts as $post) {
            $post->body = $this->shortenText($post->body, 50);
        }
        return view('frontend.blog.index',['posts' => $posts]);
    }

    public function getPostIndex()
    {
        $posts = Post::paginate(5);
        return view('admin.blog.index',['posts' => $posts]);
    }

    public function getSinglePost($post_id,$end = 'frontend')
    {
        $post = Post::find($post_id);
        if (!$post) {
            return redirect()->route('blog.index')->with(['fail' => 'Post not found']);
        }
        return view($end . '.blog.single',['post' => $post]);
    }

    public function getCreatePost()
    {
        return view('admin.blog.create_post');
    }

    public function postCreatePost(Request $request)
    {
        $this->validate($request,[
            'title' => 'required|max:120|unique:posts',
            'author' => 'required|max:80',
            'body' => 'required'
        ]);

        $post = new Post();
        $post->title = $request->title;
        $post->author = $request->author;
        $post->body = $request->body;
        $post->save();

        return redirect()->route('admin.index')->with(['success' => 'Post successfully created!']);
    }

    private function shortenText($text,$words_count)
    {
        if (mb_strlen($text) > $words_count) {
            $text = mb_substr($text,0,$words_count). '...';
        }
        return $text;
    }

    public function getUpdatePost($post_id)
    {
        $post = Post::find($post_id);
        if (!$post) {
            return redirect()->route('blog.index')->with(['fail' => 'Post not found']);
        }
        // find category
        return view('admin.blog.edit_post',['post' => $post]);
    }

    public function postUpdatePost(Request $request)
    {
         $this->validate($request,[
            'title' => 'required|max:120',
            'author' => 'required|max:80',
            'body' => 'required'
        ]);

        $post = Post::find($request->post_id);
        $post->title = $request->title;
        $post->author = $request->author;
        $post->body = $request->body;
        $post->update();
        //categories
        return redirect()->route('admin.index')->with(['success' => 'Post successfully updated']);
        
    }

    public function getDeletePost($post_id)
    {
        $post = Post::find($post_id);
        if (!$post) {
            return redirect()->route('blog.index')->with(['fail' => 'Deleted fail']);
        }
        $post->delete();
        return redirect()->route('admin.index')->with(['success' => 'Post successfully deleted']);
    }

}
