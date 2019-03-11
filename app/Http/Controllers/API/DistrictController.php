<?php


namespace App\Http\Controllers\API;


use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\District;
use Validator;


class DistrictController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $districts = District::select('districts.id','districts.title','districts.slug','districts.description','districts.img','districts.geolocation','districts.polygon','districts.area','districts.poppulation','districts.percent','districts.seotitle','districts.seodescription','province_id','provinces.title as ptitle')
                            ->join('provinces', 'districts.province_id', '=', 'provinces.id');

        if($request->lang=="en"){
            $districts = District::select('districts.id','districts.entitle','districts.slug','districts.endescription','districts.img','districts.geolocation','districts.polygon','districts.area','districts.poppulation','districts.percent','districts.seotitle','districts.seodescription','province_id','provinces.entitle as ptitle')                      
                            ->join('provinces', 'districts.province_id', '=', 'provinces.id');
        }    

        if(isset($request->province_id)){
            $districts = $districts->where('province_id',$request->province_id);
        }

        $districts = $districts->where('districts.status','PUBLISHED')
                        ->orderby('districts.pos','desc')
                        ->get();        

        if (is_null($districts)) {
            return $this->sendError('Districts not found.');
        }

        return $this->sendResponse($districts->toArray(), 'Districts retrieved successfully.');
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


        $product = District::create($input);


        return $this->sendResponse($product->toArray(), 'District created successfully.');
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $district = District::where('id', $request->id)->orWhere('slug', $request->slug)->firstOrFail();

        if (is_null($district)) {
            return $this->sendError('District not found.');
        }

        $district = District::select('districts.id','districts.title','districts.slug','districts.description','districts.img','districts.geolocation','districts.polygon','districts.area','districts.poppulation','districts.percent','districts.seotitle','districts.seodescription','province_id','provinces.title as ptitle')
                            ->join('provinces', 'districts.province_id', '=', 'provinces.id');

        if($request->lang=="en"){
            $district = District::select('districts.id','districts.entitle','districts.slug','districts.endescription','districts.img','districts.geolocation','districts.polygon','districts.area','districts.poppulation','districts.percent','districts.seotitle','districts.seodescription','province_id','provinces.entitle as ptitle')                      
                            ->join('provinces', 'districts.province_id', '=', 'provinces.id');
        }   

        $district = $district->where('districts.status','PUBLISHED')
                        ->where('districts.id', $request->id)
                        ->orWhere('districts.slug', $request->slug)
                        ->orderby('districts.pos','desc')
                        ->get();

        return $this->sendResponse($district->toArray(), 'District retrieved successfully.');
    }

    public function showAll($param = null)
    {
        if($param){
            $district = District::where('district_id', $param)->get();
        }else{
            $district = District::all();
        }

        if (is_null($district)) {
            return $this->sendError('District not found.');
        }

        return $this->sendResponse($district->toArray(), 'District retrieved successfully.');
    }

    public function showDropdown(Request $request)
    {
        $districts = District::select('id','title');

        if($request->lang=="en"){
            $districts = District::select('id','entitle');
        }

        if(isset($request->province_id)){
            $districts = $districts->where('province_id',$request->province_id);
        }

        $districts = $districts->where('districts.status','PUBLISHED')
                        ->orderby('districts.pos','desc')
                        ->get(); 

        if (is_null($districts)) {
            return $this->sendError('Districts not found.');
        }

        return $this->sendResponse($districts->toArray(), 'Districts retrieved successfully.');
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, District $District)
    {
        $input = $request->all();


        $validator = Validator::make($input, [
            'name' => 'required',
            'detail' => 'required'
        ]);


        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }


        $District->name = $input['name'];
        $District->detail = $input['detail'];
        $District->save();


        return $this->sendResponse($District->toArray(), 'District updated successfully.');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(District $District)
    {
        $District->delete();


        return $this->sendResponse($District->toArray(), 'District deleted successfully.');
    }

    public function polygon(Request $request){

        $district = District::find($request->id);

        return $this->getPolygon($district->polygon);

    }
}