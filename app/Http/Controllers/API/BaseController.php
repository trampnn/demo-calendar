<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller as Controller;


class BaseController extends Controller
{
    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function sendResponse($result, $message)
    {
    	$response = [
            'success' => true,
            'data'    => $result,
            'message' => $message,
        ];

        return response()->json($response, 200);
    }


    /**
     * return error response.
     *
     * @return \Illuminate\Http\Response
     */
    public function sendError($error, $errorMessages = [], $code = 404)
    {
    	$response = [
            'success' => false,
            'message' => $error,
        ];

        if(!empty($errorMessages)){
            $response['data'] = $errorMessages;
        }

        return response()->json($response, $code);
    }

    public function getPolygon($polygon){        
        
        $arrPoint = explode(";",$polygon);

        $arrpolygon = $arrPoint;

        if(sizeof($arrPoint) < 2){
            $arr = explode("END", file_get_contents("http://polygons.openstreetmap.fr/get_poly.py?id=".$polygon."&params=0")); 
            $arrpolygon = [];
            $index = 0;
            foreach($arr as $p){
                $arr_p = explode("\n",$p);
                $arrPoint = "";
                if(sizeof($arr_p)>2){
                    foreach($arr_p as $location){
                        $point = explode("\t",$location);
                        if(sizeof($point)>2){
                          $arrPoint .= $point[2].','.$point[1].';'; // lat-lng
                        }
                    }
                    $arrPoint = substr_replace($arrPoint ,"",-1);          
                $arrpolygon[$index] = $arrPoint;
                $index++;
                }  
                
            }
        }       


        //$array = explode("\n", file_get_contents("http://polygons.openstreetmap.fr/get_poly.py?id=".$polygon."&params=0")); 


        // $arrPoint = "";
        // foreach($array as $location){
        //     $point = explode("\t",$location);
        //     if(sizeof($point)>2){
        //       $arrPoint .= $point[2].','.$point[1].';'; // lat-lng
        //     }
        // }
        // $arrPoint = substr_replace($arrPoint ,"",-1);

        // $location = $arrPoint;

        // //return json_encode($location);

        // //$location = '[{"lat":21.0121742,"lng":105.3175069},{"lat":21.0134907,"lng":105.3195041}]';

        $response = [
            'success' => true,
            'data'    => $arrpolygon,
            'message' => "Polygon retrieved successfully.",
        ];

        return response()->json($response, 200);
    }
}