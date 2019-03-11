<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Post;
use DB,Validator;

class GalleryController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $path = "public/photos/*.*";

        // Sort in ascending order - this is default
        $files = glob(Storage::path($path));
        
        // $images = [];
        
        // for ($i=1; $i<count($files); $i++)
        // {
        //     $images[i] = $files[$i];
        // }

        return $this->sendResponse($files, 'Gallery retrieved successfully.');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {
        $photo = $request->photo;
        
        //$data = 'data:image/jpeg;base64,/9j/4AAQSkZJRgABAQAAAQABAA.';
        $pos  = strpos($photo, ';');
        $type = explode(':', substr($photo, 0, $pos))[1];
        
        $today = getdate();
        
        $path = "public/photos/".$today[0];
        
        if($type=="image/jpeg")
            $path .= ".jpg";
        if($type=="image/png")
            $path .= ".png";

        $full_path = Storage::path($path);

        file_put_contents($path,base64_decode(explode(',',$photo)[1]));

        return $this->sendResponse($path, 'Photo created successfully.');
    }





    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function show($id)
    {
        $post = DB::table('posts')
            ->join('users', 'users.id', '=', 'posts.author_id')
            ->select('posts.*', 'users.name', 'users.avatar')
            ->where('posts.id','=',$id)
            ->first();

        if (is_null($post)) {
            return $this->sendError('Post not found.');
        }

        return $this->sendResponse($post, 'Post  successfully.');

    }

    public function showList($id)
    {
        $post = DB::table('posts')
            ->join('users', 'users.id', '=', 'posts.author_id')
            ->select('posts.*', 'users.avatar')
            ->get();

        if (is_null($post)) {
            return $this->sendError('Post not found.');
        }

        return $this->sendResponse($post->toArray(), 'Post retrieved successfully.');

    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function update(Request $request)
    {
        $input = $request->all();

        $post = Post::find($input['id']);

        if (!$post) {
            return $this->sendError('Post not found', 400); 
        }

        $validator = Validator::make($input, [
            'title' => 'required',
            'body' => 'required'
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());   
        }

        $post->title = $input['title'];
        $post->body = $input['body'];

        $updated = $post->save();

        if ($updated){
            $post = Post::find($input['id']);
            return $this->sendResponse($post, 'Post updated successfully.');
        }else{
            return $this->sendError('Post update error', 500); 
        }
    }

    public function updatePending(Request $request)
    {
        $input = $request->all();

        $post = Post::find($input['id']);

        if (!$post) {
            return $this->sendError('Post not found', 400); 
        }

        $post->status = "PENDING";

        $updated = $post->save();

        if ($updated){
            $post = Post::find($input['id']);
            return $this->sendResponse($post, 'Post updated successfully.');
        }else{
            return $this->sendError('Post update error', 500); 
        }
    }

    public function updatePublic(Request $request)
    {
        $input = $request->all();

        $post = Post::find($input['id']);

        if (!$post) {
            return $this->sendError('Post not found', 400); 
        }

        $post->status = "PUBLISHED";

        $updated = $post->save();

        if ($updated){
            $post = Post::find($input['id']);
            return $this->sendResponse($post, 'Post updated successfully.');
        }else{
            return $this->sendError('Post update error', 500); 
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function destroy(Request $request)
    {
        unlink($request->image);

        return $this->sendResponse('Image deleted successfully.',200);
    }
}