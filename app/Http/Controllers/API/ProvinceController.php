<?php


namespace App\Http\Controllers\API;


use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Province;
use Validator;


class ProvinceController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $provinces = Province::select('provinces.id','provinces.title','provinces.slug','description','img','provinces.geolocation','provinces.polygon','provinces.area','provinces.poppulation','provinces.percent','provinces.seotitle','provinces.seodescription','country_id','countries.shortform')
                            ->join('countries', 'provinces.country_id', '=', 'countries.id');

        if($request->lang=="en"){
            $provinces = Province::select('provinces.id','provinces.entitle','provinces.slug','endescription','img','provinces.geolocation','provinces.polygon','provinces.area','provinces.poppulation','provinces.percent','provinces.seotitle','provinces.seodescription','country_id','countries.enshortform')                      
                            ->join('countries', 'provinces.country_id', '=', 'countries.id');
        }    

        if(isset($request->country_id)){
            $provinces = $provinces->where('country_id',$request->country_id);
        }

        $provinces = $provinces->where('provinces.status','PUBLISHED')
                        ->orderby('provinces.pos','desc')
                        ->get();        

        if (is_null($provinces)) {
            return $this->sendError('Provinces not found.');
        }

        return $this->sendResponse($provinces->toArray(), 'Provinces retrieved successfully.');
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


        $product = Province::create($input);


        return $this->sendResponse($product->toArray(), 'Province created successfully.');
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $province = Province::where('id', $request->id)->orWhere('slug', $request->slug)->firstOrFail();

        if (is_null($province)) {
            return $this->sendError('Province not found.');
        }

        $province = Province::select('provinces.id','provinces.title','provinces.slug','description','img','provinces.geolocation','provinces.polygon','provinces.area','provinces.poppulation','provinces.percent','provinces.seotitle','provinces.seodescription','country_id','countries.shortform')
                            ->join('countries', 'provinces.country_id', '=', 'countries.id');

        if($request->lang=="en"){
            $province = Province::select('provinces.id','provinces.entitle','provinces.slug','endescription','img','provinces.geolocation','provinces.polygon','provinces.area','provinces.poppulation','provinces.percent','provinces.seotitle','provinces.seodescription','country_id','countries.enshortform')                      
                            ->join('countries', 'provinces.country_id', '=', 'countries.id');
        }    

        $province = $province->where('provinces.status','PUBLISHED')
                        ->where('provinces.id', $request->id)
                        ->orWhere('provinces.slug', $request->slug)
                        ->orderby('provinces.pos','desc')
                        ->get();

        return $this->sendResponse($province->toArray(), 'Province retrieved successfully.');
    }

    public function showAll($param = null)
    {
        if($param){
            $province = Province::where('country_id', $param)->get();
        }else{
            $province = Province::all();
        }

        if (is_null($province)) {
            return $this->sendError('Province not found.');
        }

        return $this->sendResponse($province->toArray(), 'Province retrieved successfully.');
    }

    public function showDropdown(Request $request)
    {
        $provinces = Province::select('id','title');

        if($request->lang=="en"){
            $provinces = Province::select('id','entitle');
        }

        if(isset($request->country_id)){
            $provinces = $provinces->where('country_id',$request->country_id);
        }

        $provinces = $provinces->where('provinces.status','PUBLISHED')
                        ->orderby('provinces.pos','desc')
                        ->get();        

        if (is_null($provinces)) {
            return $this->sendError('Provinces not found.');
        }

        return $this->sendResponse($provinces->toArray(), 'Provinces retrieved successfully.');
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Province $province)
    {
        $input = $request->all();


        $validator = Validator::make($input, [
            'name' => 'required',
            'detail' => 'required'
        ]);


        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }


        $province->name = $input['name'];
        $province->detail = $input['detail'];
        $province->save();


        return $this->sendResponse($province->toArray(), 'Province updated successfully.');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Province $province)
    {
        $province->delete();


        return $this->sendResponse($province->toArray(), 'Province deleted successfully.');
    }

    public function polygon(Request $request){

        $province = Province::find($request->id);

        return $this->getPolygon($province->polygon);

    }
}