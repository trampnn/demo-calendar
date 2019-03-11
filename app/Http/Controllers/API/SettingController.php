<?php


namespace App\Http\Controllers\API;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Setting;
use Validator;


class SettingController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $setting = Setting::all();

        return $this->sendResponse($setting->toArray(), 'Setting retrieved successfully.');
    }

    public function site()
    {
        $setting = Setting::select('id','key','display_name','value','group')
                    ->where('group','site')
                    ->orderby('order','desc')
                    ->get(); 

        return $this->sendResponse($setting->toArray(), 'Setting retrieved successfully.');
    }

    public function admin()
    {
        $setting = Setting::select('id','key','display_name','value','group')
                    ->where('group','admin')
                    ->orderby('order','desc')
                    ->get(); 

        return $this->sendResponse($setting->toArray(), 'Setting retrieved successfully.');
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

            'name' => 'required',

            'detail' => 'required'

        ]);

        if($validator->fails()){

            return $this->sendError('Validation Error.', $validator->errors());       

        }

        $contact = Contact::create($input);

        return $this->sendResponse($contact->toArray(), 'Contact created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function show(Request $request)
    {
        $setting = Setting::find($request->id);
        
        if (is_null($setting)) {
            return $this->sendError('Setting not found.');
        }

        return $this->sendResponse($setting, 'Setting retrieved successfully.');
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

        $setting = Setting::find($input['id']);

        if (!$setting) {
            return $this->sendError('Setting not found', 400); 
        }

        $validator = Validator::make($input, [
            'value' => 'required'
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());   
        }

        $setting->value = $input['value'];

        $updated = $setting->save();

        if ($updated){
            return $this->sendResponse($setting->toArray(), 'Setting updated successfully.');
        }else{
            return $this->sendError('Setting update error', 500); 
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function destroy(Contact $contact)
    {

        $contact->delete();

        return $this->sendResponse($contact->toArray(), 'Contact deleted successfully.');

    }
}