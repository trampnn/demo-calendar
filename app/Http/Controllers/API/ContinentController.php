<?php


namespace App\Http\Controllers\API;


use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Continent;
use Validator;


class ContinentController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $continents = Continent::select('id','title','slug','description','img','area','population','percent','parent','seotitle','seodescription','pos' ,'status')
                        ->where('status','PUBLISHED')
                        ->orderby('pos','desc')
                        ->get();

        if($request->lang=="en"){
            $continents = Continent::select('id','entitle','slug','endescription','img','area','population','percent','parent','seotitle','seodescription','pos' ,'status')
                            ->where('status','PUBLISHED')
                            ->orderby('pos','desc')
                            ->get();
        }
            
        return $this->sendResponse($continents->toArray(), 'Continents retrieved successfully.');
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
        $continent = Continent::where('id', $request->id)->orWhere('slug', $request->slug)->firstOrFail();

        if (is_null($continent)) {
            return $this->sendError('Continent not found.');
        }

        $continent = Continent::select('id','title','slug','description','img','area','population','percent','parent','seotitle','seodescription','pos' ,'status')
                        ->where('id', $request->id)
                        ->orWhere('slug', $request->slug)
                        ->where('status','PUBLISHED')
                        ->orderby('pos','desc')
                        ->get();

        if($request->lang=="en"){
            $continent = Continent::select('id','entitle','slug','endescription','img','area','population','percent','parent','seotitle','seodescription','pos' ,'status')
                            ->where('id', $request->id)
                            ->orWhere('slug', $request->slug)
                            ->where('status','PUBLISHED')
                            ->orderby('pos','desc')
                            ->get();
        }

        return $this->sendResponse($continent->toArray(), 'Continent retrieved successfully.');
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
    public function update(Request $request, Continent $product)
    {
        $input = $request->all();


        $validator = Validator::make($input, [
            'name' => 'required',
            'detail' => 'required'
        ]);


        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }


        $product->name = $input['name'];
        $product->detail = $input['detail'];
        $product->save();


        return $this->sendResponse($product->toArray(), 'Continent updated successfully.');
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