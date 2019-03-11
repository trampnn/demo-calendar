<?php


namespace App\Http\Controllers\API;


use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Ward;
use Validator;


class WardController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $wards = Ward::select('wards.id','wards.title','wards.slug','wards.description','wards.img','wards.geolocation','wards.polygon','wards.area','wards.poppulation','wards.percent','wards.seotitle','wards.seodescription','district_id','districts.title as dtitle')
                            ->join('districts', 'wards.district_id', '=', 'districts.id');

        if($request->lang=="en"){
            $wards = Ward::select('wards.id','wards.entitle','wards.slug','wards.endescription','wards.img','wards.geolocation','wards.polygon','wards.area','wards.poppulation','wards.percent','wards.seotitle','wards.seodescription','district_id','districts.entitle as dtitle')                      
                            ->join('districts', 'wards.district_id', '=', 'districts.id');
        }    

        if(isset($request->district_id)){
            $wards = $wards->where('district_id',$request->district_id);
        }

        $wards = $wards->where('wards.status','PUBLISHED')
                        ->orderby('wards.pos','desc')
                        ->get();        

        if (is_null($wards)) {
            return $this->sendError('Wards not found.');
        }

        return $this->sendResponse($wards->toArray(), 'Wards retrieved successfully.');
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


        $product = Ward::create($input);


        return $this->sendResponse($product->toArray(), 'Ward created successfully.');
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $ward = Ward::where('id', $request->id)->orWhere('slug', $request->slug)->firstOrFail();

        if (is_null($ward)) {
            return $this->sendError('Ward not found.');
        }

        $ward = Ward::select('wards.id','wards.title','wards.slug','wards.description','wards.img','wards.geolocation','wards.polygon','wards.area','wards.poppulation','wards.percent','wards.seotitle','wards.seodescription','district_id','districts.title as dtitle')
                            ->join('districts', 'wards.district_id', '=', 'districts.id');

        if($request->lang=="en"){
            $ward = Ward::select('wards.id','wards.entitle','wards.slug','wards.endescription','wards.img','wards.geolocation','wards.polygon','wards.area','wards.poppulation','wards.percent','wards.seotitle','wards.seodescription','district_id','districts.entitle as dtitle')                      
                            ->join('districts', 'wards.district_id', '=', 'districts.id');
        }   

        $ward = $ward->where('wards.status','PUBLISHED')
                        ->where('wards.id', $request->id)
                        ->orWhere('wards.slug', $request->slug)
                        ->orderby('wards.pos','desc')
                        ->get();

        return $this->sendResponse($ward->toArray(), 'Ward retrieved successfully.');
    }

    public function showAll($param = null)
    {
        if($param){
            $ward = Ward::where('ward_id', $param)->get();
        }else{
            $ward = Ward::all();
        }

        if (is_null($ward)) {
            return $this->sendError('Ward not found.');
        }

        return $this->sendResponse($ward->toArray(), 'Ward retrieved successfully.');
    }

    public function showDropdown(Request $request)
    {
        $wards = Ward::select('id','title');

        if($request->lang=="en"){
            $wards = Ward::select('id','entitle');
        }

        if(isset($request->district_id)){
            $wards = $wards->where('district_id',$request->district_id);
        }

        $wards = $wards->where('wards.status','PUBLISHED')
                        ->orderby('wards.pos','desc')
                        ->get(); 

        if (is_null($wards)) {
            return $this->sendError('Wards not found.');
        }

        return $this->sendResponse($wards->toArray(), 'Wards retrieved successfully.');
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Ward $Ward)
    {
        $input = $request->all();


        $validator = Validator::make($input, [
            'name' => 'required',
            'detail' => 'required'
        ]);


        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }


        $Ward->name = $input['name'];
        $Ward->detail = $input['detail'];
        $Ward->save();


        return $this->sendResponse($Ward->toArray(), 'Ward updated successfully.');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Ward $Ward)
    {
        $Ward->delete();


        return $this->sendResponse($Ward->toArray(), 'Ward deleted successfully.');
    }

    public function polygon(Request $request){

        $ward = Ward::find($request->id);

        return $this->getPolygon($ward->polygon);

    }
}