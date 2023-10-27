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

        $resturant = RestaturantLocationResource::collection(RestaurantLocation::where('restaurant_id', $restaurant_id)->get());

        dd($resturant);

        return RiderLocationResource::collection(RiderLocation::where('rider_id', $rider_id)->get());

    }
}
