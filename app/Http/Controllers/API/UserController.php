<?php


namespace App\Http\Controllers\API;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\API\BaseController as BaseController;
use Illuminate\Support\Facades\Hash;
use App\User;
use Validator;

use DB;

class UserController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();

        return $this->sendResponse($users->toArray(), 'Users retrieved successfully.');
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


        $product = Continent::create($input);


        return $this->sendResponse($product->toArray(), 'Continent created successfully.');
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $user = DB::table('users')->select('users.*','roles.name as role_name')->where('users.email', '=', $request->email)->join('roles', 'users.role_id', '=', 'roles.id')->first();
        
        $user->avatar = env('APP_URL').'/storage/app/public/'.$user->avatar;

        //$user = User::where('name', '=', $request->name)->firstOrFail();

        if (is_null($user)) {
            return $this->sendError('Validation Error.', $validator->errors());  
        }

        return $this->sendResponse($user, 'User retrieved successfully.');
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
        //$input = $request->all();
        $user = User::find($request->id);
 
        if (!$user) {
            return $this->sendError('User not found', 400); 
        }
        
        if(isset($request->name))
            $user->name = $request->name;
        if(isset($request->email))
            $user->email = $request->email;
        if(isset($request->password))
            $user->password = Hash::make($request->password);
        $updated = $user->save();
        
        $user = User::find($request->id);
 
        if ($updated)
            return $this->sendResponse($user, 'User updated successfully.');
        else
            return $this->sendError('User update error', 500); 
        
    }
    
    public function updateInfo(Request $request)
    {
        $user = User::find($request->id);
 
        if (!$user) {
            return $this->sendError('User not found', 400); 
        }
        
        if(isset($request->name))
            $user->name = $request->name;
        if(isset($request->email))
            $user->email = $request->email;
        if(isset($request->password))
            $user->password = Hash::make($request->password);
        $updated = $user->save();
 
        $user = User::find($request->id);
        $user->avatar = env('APP_URL').'/storage/app/public/'.$user->avatar;

        if ($updated)
            return $this->sendResponse($user, 'User updated successfully.');
        else
            return $this->sendError('User update error', 500); 
    }

    public function updateAvatar(Request $request)
    {
        $user = User::find($request->id);
 
        if (!$user) {
            return $this->sendError('User not found', 400); 
        }
        
        $avatar = $request->avatar;
        
        //$data = 'data:image/jpeg;base64,/9j/4AAQSkZJRgABAQAAAQABAA.';
        $pos  = strpos($avatar, ';');
        $type = explode(':', substr($avatar, 0, $pos))[1];
        
        $today = getdate();

        $path = "/public/users/".$today[0];
        
        if($type=="image/jpeg")
            $path .= ".jpg";
        if($type=="image/png")
            $path .= ".png";
 
        $full_path = Storage::path($path);

        file_put_contents($full_path,base64_decode(explode(',',$avatar)[1]));
        
        $updated = User::where('id','=',$request->id)->update(['avatar' => $path]);

        $user = User::find($request->id);
        $user->avatar = env('APP_URL').'/storage/app/public/'.$user->avatar;

        if ($updated)
            return $this->sendResponse($user, 'User updated successfully.');
        else
            return $this->sendError('User update error', 500);        
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