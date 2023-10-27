<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\RiderLocationResource;
use App\Http\Resources\RestaturantLocationResource;
use App\Models\RiderLocation;
use App\Models\RestaurantLocation;

class RiderLocationController extends Controller
{
    
    public function setRiderLocation(Request $request)
    {
        $rider_id = $request->rider_id;
        $lat = $request->location_lat;
        $long = $request->location_long; 
        $service_name = $request->service_nmame;

        //dd($service_name);

        RiderLocation::insert(['service_name' => $service_name, 'lat' => $lat, 'long' => $long, 'rider_id' => $rider_id]);

        return response()->json(['success' => 'Location Created Sussesfully']);


    }


    public function getRiderLocation(Request $request)
    {

        $rider_id = $request->rider_id;
        $restaurant_id = $request->restaurant_id;

        $resturant = RestaurantLocation::where('restaurant_id', $restaurant_id)->first();
        
        $rider_location =RiderLocation::where('rider_id', $rider_id)->first();

        $distance = round((((acos(sin(($resturant->lat*pi()/180)) * sin(($rider_location->lat*pi()/180))+cos(($resturant->lat*pi()/180)) * cos(($rider_location->lat*pi()/180)) * cos((($resturant->long - $rider_location->long)*pi()/180))))*180/pi())*60*1.1515*1.609344), 2);

        return response()->json(['location_distance' => $distance]);

    }
}
