<?php

namespace App\Http\Controllers\Api;

use App\Models\Post;
use App\Trait\PostTrait;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use App\Http\Resources\PostCollection;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    use PostTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = new PostCollection( Post::all() );

        if($posts) {
            return $posts;
        }else{
            return $this->response(null, 200, 'Oops, Not Found');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        // $request->validate([
        //     'title' => 'required|min:3',
        //     'body' => 'required|min:5',
        // ]);
        $validator = Validator::make($request->all(), [
            'title' => 'required|min:3|max:255',
            'body' => 'required|min:5',
        ]);

        if($validator->fails()) {
            return $this->response(null, 400, $validator->errors());
        }

        $post = Post::create($request->all());

        if($post) {
            return $this->response(new PostResource($post), 201, 'Post Successfully Created!');
        }else{
            return $this->response($post, 400, 'There Is Error!');
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
        $post = Post::find($id);

        if($post) {
            return $this->response(new PostResource($post), 200, 'Ok, Found it');
        }else{
            return $this->response(null, 200, 'Oops, Not Found');
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
        $post = Post::find($id);

        // If Not Found (Before Update)
        if(!$post) {
            return $this->response(null, 404, 'Not Found!');
        }

        $validator = Validator::make($request->all(), [
            'title' => 'required|min:3|max:255',
            'body' => 'required|min:5',
        ]);

        if($validator->fails()) {
            return $this->response(null, 400, $validator->errors());
        }

        // Found
        $post->update($request->all());

        if($post) {
            return $this->response(new PostResource($post), 201, 'Post Successfully Updated!');
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
        $post = Post::find($id);

        if(!$post) {
            return $this->response(null, 404, 'Not Found!');
        }

        $post->delete();

        if($post) {
            return $this->response(null, 200, 'Post Successfully Deleted!');
        }
    }
}
