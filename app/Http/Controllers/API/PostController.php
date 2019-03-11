<?php


namespace App\Http\Controllers\API;


use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Post;
use Validator;


class PostController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $posts = Post::select('posts.id','title','excerpt','posts.slug','body','image','author_id','category_id','seo_title','meta_description','meta_keywords','featured','status','users.name  as author','users.avatar','categories.name as category')
                        ->join('users', 'posts.author_id', '=', 'users.id')
                        ->join('categories', 'posts.category_id', '=', 'categories.id');

        switch($request->status){
            case "pending":
                $posts = $posts->where('posts.status','PENDING');
                break;
            case "draft":
                $posts = $posts->where('posts.status','DRAFT');
                break;
            default:
                $posts = $posts->where('posts.status','PUBLISHED');
        }
        
        $posts = $posts->get();

        return $this->sendResponse($posts->toArray(), 'Posts retrieved successfully.');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'title' => 'required',
            'excerpt' => 'required',
            'body' => 'required',
            'author_id' => 'required',
            'category_id' => 'required',
            'slug' => 'required',
            'seo_title' => 'required',
            'meta_description' => 'required',
            'meta_keywords' => 'required'
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }
 
        $post = Post::create($input);

        return $this->sendResponse($post->toArray(), 'Post created successfully.');
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $post = Post::where('id', $request->id)->orWhere('slug', $request->slug)->firstOrFail();

        if (is_null($posts)) {
            return $this->sendError('Post not found.');
        }

        $post = Post::select('posts.id','title','excerpt','posts.slug','body','image','author_id','category_id','seo_title','meta_description','meta_keywords','featured','users.name','categories.name')
                        ->where('posts.id', $request->id)
                        ->join('users', 'posts.author_id', '=', 'users.id')
                        ->join('categories', 'posts.category_id', '=', 'categories.id');

        if(!$request->admin)
            $post = $post->where('posts.status','PUBLISHED');

        $post=$post->get();

        return $this->sendResponse($post->toArray(), 'Post retrieved successfully.');
    }

    public function showDropdown(Request $request)
    {
        $continent = Continent::select('id','title')->get();

        if($request->lang=="en"){
            $continent = Continent::select('id','entitle')->get();
        }
        
        if (is_null($continent)) {
            return $this->sendError('Continent not found.');
        }

        return $this->sendResponse($continent->toArray(), 'Continent retrieved successfully.');
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

        $post = Post::where('id', $request->id)->orWhere('slug', $request->slug)->firstOrFail();

        if (is_null($post)) {
            return $this->sendError('Post not found.');
        }

        $validator = Validator::make($input, [
            'title' => 'required',
            'excerpt' => 'required',
            'body' => 'required',
            'author_id' => 'required',
            'category_id' => 'required',
            'slug' => 'required',
            'seo_title' => 'required',
            'meta_description' => 'required',
            'meta_keywords' => 'required'
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }

        $post->title = $input['title'];
        $post->excerpt = $input['excerpt'];
        $post->body = $input['body'];
        $post->author_id = $input['author_id'];
        $post->category_id = $input['category_id'];
        $post->slug = $input['slug'];
        $post->seo_title = $input['seo_title'];
        $post->meta_description = $input['meta_description'];
        $post->meta_keywords = $input['meta_keywords'];
        $post->save();

        $post = Post::where('id', $request->id)->orWhere('slug', $request->slug)->firstOrFail();

        return $this->sendResponse($post->toArray(), 'Post updated successfully.');
    }

    public function updateImg(Request $request)
    {
        $input = $request->all();

        $post = Post::where('id', $request->id)->orWhere('slug', $request->slug)->firstOrFail();

        if (is_null($post)) {
            return $this->sendError('Post not found.');
        }
        
        $img = $request->photo;
        
        //$data = 'data:image/jpeg;base64,/9j/4AAQSkZJRgABAQAAAQABAA.';
        $pos  = strpos($img, ';');
        $type = explode(':', substr($img, 0, $pos))[1];
        
        $path = "posts/".$request->id.'-'.date("Ymd");
        
        if($type=="image/jpeg")
            $path .= ".jpg";
        if($type=="image/png")
            $path .= ".png";
 
        file_put_contents("storage/".$path,base64_decode(explode(',',$img)[1]));

        $updated = Post::where('id','=',$request->id)->update(['image' => $path]);

        $post = Post::where('id', $request->id)->orWhere('slug', $request->slug)->firstOrFail();

        return $this->sendResponse($post->toArray(), 'Post updated successfully.');
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
        $post = Post::find($request->id);

        if (!$post) {
            return $this->sendError('Post not found', 400); 
        }

        $post->delete();

        return $this->sendResponse($post->toArray(), 'Post deleted successfully.');
    }
}