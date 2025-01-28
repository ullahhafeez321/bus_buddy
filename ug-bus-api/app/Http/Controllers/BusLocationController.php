<?php

namespace App\Http\Controllers;

use App\Models\BusLocation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class BusLocationController extends Controller
{
    // Store bus location from driver's app
    public function store(Request $request)
    {
        $driverLocation = $request->all();
    
        // Store the driver's location in the cache for 5 minutes
        Cache::put('driver_location', $driverLocation, now()->addMinutes(5));

    
        return response()->json(['status' => 'success']);
    }

    // Get the latest bus location
    public function getLatestLocation()
    {
        $driverLocation = Cache::get('driver_location');

        if ($driverLocation) {
            return response()->json(['location' => $driverLocation]);
        } else {
            return response()->json(['error' => 'Location not found'], 404);
        }
    }
}

