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

       // $distance = round((((acos(sin(($resturant->lat*pi()/180)) * sin(($rider_location->lat*pi()/180))+cos(($resturant->lat*pi()/180)) * cos(($rider_location->lat*pi()/180)) * cos((($resturant->long - $rider_location->long)*pi()/180))))*180/pi())*60*1.1515*1.609344), 2);

        $distance = $this->haversineGreatCircleDistance($resturant->lat, $resturant->long, $rider_location->lat, $rider_location->long);

        return response()->json(['location_distance' => $distance]);

    }

public function haversineGreatCircleDistance(
  $latitudeFrom, $longitudeFrom, $latitudeTo, $longitudeTo, $earthRadius = 6371000)
{
  // convert from degrees to radians
  $latFrom = deg2rad($latitudeFrom);
  $lonFrom = deg2rad($longitudeFrom);
  $latTo = deg2rad($latitudeTo);
  $lonTo = deg2rad($longitudeTo);

  $latDelta = $latTo - $latFrom;
  $lonDelta = $lonTo - $lonFrom;

  $angle = 2 * asin(sqrt(pow(sin($latDelta / 2), 2) +
    cos($latFrom) * cos($latTo) * pow(sin($lonDelta / 2), 2)));
  return ($angle * $earthRadius)/1000;
}

public function getDistance(
  $latitudeFrom, $longitudeFrom, $latitudeTo, $longitudeTo)
{


//Calculate distance from latitude and longitude
$theta = $longitudeFrom - $longitudeTo;
$dist = sin(deg2rad($latitudeFrom)) * sin(deg2rad($latitudeTo)) +  cos(deg2rad($latitudeFrom)) * cos(deg2rad($latitudeTo)) * cos(deg2rad($theta));
$dist = acos($dist);
$dist = rad2deg($dist);
$miles = $dist * 60 * 1.1515;

return $distance = ($miles * 1.609344).' km';
}
}
