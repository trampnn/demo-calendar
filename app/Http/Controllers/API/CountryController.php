<?php
namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Country;
use Validator;

class CountryController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request)
    {
        $countries = Country::select('countries.id','longform','shortform','countries.slug','intro','flag','emblem','anthem','map','capital','countries.geolocation','countries.polygon','countries.area','independence','natonal_holiday','currency','timezone','internet_code','three_letter_country_code','calling_code','land_boundaries','coastline','countries.population','nationality','regions','gdp','countries.seotitle','countries.seodescription','continent_id','continents.title')
                            ->join('continents', 'countries.continent_id', '=', 'continents.id');


        if($request->lang=="en"){
            $countries = Country::select('countries.id','enlongform','enshortform','countries.slug','intro','flag','emblem','anthem','map','capital','countries.geolocation','countries.polygon','countries.area','independence','natonal_holiday','currency','timezone','internet_code','three_letter_country_code','calling_code','land_boundaries','coastline','countries.population','nationality','regions','gdp','countries.seotitle','countries.seodescription','continent_id','continents.entitle')                      
                            ->join('continents', 'countries.continent_id', '=', 'continents.id');
        }        

        switch($request->continent_id){
            case 1:
                $countries = $countries->whereIn('continent_id', array(5, 7, 8));
                break;
            case 2:
                $countries = $countries->whereIn('continent_id', array(9,10));
                break;
            case 6:
                $countries = $countries->whereIn('continent_id', array(7, 8));
                break;
        } 

        $countries = $countries->where('countries.status','PUBLISHED')
                        ->orderby('countries.pos','desc')
                        ->get();        

        if (is_null($countries)) {
            return $this->sendError('Countries not found.');
        }

        return $this->sendResponse($countries->toArray(), 'Countries retrieved successfully.');
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
        $country = Country::where('id', $request->id)->orWhere('slug', $request->slug)->firstOrFail();

        if (is_null($country)) {
            return $this->sendError('Country not found.');
        }

        $country = Country::select('countries.id','longform','shortform','countries.slug','intro','flag','emblem','anthem','map','capital','countries.geolocation','countries.polygon','countries.area','independence','natonal_holiday','currency','timezone','internet_code','three_letter_country_code','calling_code','land_boundaries','coastline','countries.population','nationality','regions','gdp','countries.seotitle','countries.seodescription','continent_id','continents.title')
                            ->join('continents', 'countries.continent_id', '=', 'continents.id');

        if($request->lang=="en"){
            $country = Country::select('countries.id','enlongform','enshortform','countries.slug','intro','flag','emblem','anthem','map','capital','countries.geolocation','countries.polygon','countries.area','independence','natonal_holiday','currency','timezone','internet_code','three_letter_country_code','calling_code','land_boundaries','coastline','countries.population','nationality','regions','gdp','countries.seotitle','countries.seodescription','continent_id','continents.entitle')                      
                            ->join('continents', 'countries.continent_id', '=', 'continents.id');
        }  
        
        $country = $country->where('countries.status','PUBLISHED')
                        ->where('countries.id', $request->id)
                        ->orWhere('countries.slug', $request->slug)
                        ->orderby('countries.pos','desc')
                        ->get(); 

        return $this->sendResponse($country->toArray(), 'Country retrieved successfully.');
    }

    public function showAll($param = null)
    {
        $country = Country::all();

        if($param){
            switch($param){
                case 1:
                    $country = Country::whereIn('continent_id', array(5, 7, 8))->get();
                    break;
                case 2:
                    $country = Country::whereIn('continent_id', array(9,10))->get();
                    break;
                case 6:
                    $country = Country::whereIn('continent_id', array(7, 8))->get();
                    break;
                default:
                    $country = Country::where('continent_id', $param)->get();
            } 
        }  

        if (is_null($country)) {
            return $this->sendError('Country not found.');
        }

        return $this->sendResponse($country->toArray(), 'Country retrieved successfully.');
    }



    public function showDropdown(Request $request)
    {
        $countries = Country::select('id','shortform');

        if($request->lang=="en"){
            $countries = Country::select('id','enshortform');
        }

        switch($request->continent_id){
            case 1:
                $countries = $countries->whereIn('continent_id', array(5, 7, 8));
                break;
            case 2:
                $countries = $countries->whereIn('continent_id', array(9,10));
                break;
            case 6:
                $countries = $countries->whereIn('continent_id', array(7, 8));
                break;
        } 

        $countries = $countries->where('status','PUBLISHED')
                        ->orderby('pos','desc')
                        ->get();        

        if (is_null($countries)) {
            return $this->sendError('Countries not found.');
        }

        return $this->sendResponse($countries->toArray(), 'Countries retrieved successfully.');

    }



    public function showWorld(Request $request)
    {
        $countries = Country::select('id','shortform','capital','geolocation','polygon');

        if($request->lang=="en"){
            $countries = Country::select('id','enshortform','capital','geolocation','polygon');
        }

        switch($request->continent_id){
            case 1:
                $countries = $countries->whereIn('continent_id', array(5, 7, 8));
                break;
            case 2:
                $countries = $countries->whereIn('continent_id', array(9,10));
                break;
            case 6:
                $countries = $countries->whereIn('continent_id', array(7, 8));
                break;
        } 

        $countries = $countries->where('status','PUBLISHED')
                        ->orderby('pos','desc')
                        ->get(); 

        if (is_null($countries)) {
            return $this->sendError('Countries not found.');
        }

        return $this->sendResponse($countries->toArray(), 'Countries retrieved successfully.');
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



    public function polygon(Request $request)
    {
        $country = Country::find($request->id);

        return $this->getPolygon($country->polygon);
    }
}