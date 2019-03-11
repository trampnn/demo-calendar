<?php


namespace App\Http\Controllers\API;


use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Category;
use Validator;


class CategoryController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $categories = Category::select('id','name','slug','parent_id')                        
                        ->orderby('order','desc')
                        ->get();

        return $this->sendResponse($categories->toArray(), 'Categories retrieved successfully.');
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
            'description' => 'required',
            'area' => 'required',
            'population' => 'required'
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }
 
        $continent = Continent::create($input);

        return $this->sendResponse($continent->toArray(), 'Continent created successfully.');
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
                        ->join('categories', 'posts.category_id', '=', 'categories.id')
                        ->where('posts.status','PUBLISHED')
                        ->get();

        return $this->sendResponse($post->toArray(), 'Post retrieved successfully.');
    }

    public function showDropdown(Request $request)
    {
        $categories = Category::select('id','name')->get();
        
        if (is_null($categories)) {
            return $this->sendError('Categoryies not found.');
        }

        return $this->sendResponse($categories->toArray(), 'Categories retrieved successfully.');
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


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Continent $product)
    {
        $product->delete();


        return $this->sendResponse($product->toArray(), 'Continent deleted successfully.');
    }
}