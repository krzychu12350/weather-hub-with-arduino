<?php

namespace App\Http\Controllers;

use App\Models\HomeWeatherLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class HomeWeatherLogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {

        return response()->json([
            'status' => true,
            'data' => HomeWeatherLog::all(),
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
         //dd($request->get('temperature'));
        $request_data = $request->all();

        $validator = Validator::make($request_data, [
            'temperature_at_home' => 'required',
            'humidity_at_home' => 'required',
            'pressure_at_home' => 'required',
            'light_intensity_at_home' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Invalid Inputs',
                'error' => $validator->errors()
            ]);
        }

        $homeWeatherLog = HomeWeatherLog::create($request_data);

        \Illuminate\Support\Facades\Storage::append("arduino-log.txt",
            "Time: " . now()->format("Y-m-d H:i:s") . ', ' .
            /*
            "Temperature: " . $request->get("temperature", "n/a") . '°C, ' .
            "Humidity: " . $request->get("humidity", "n/a") . '%'
            */
            "Temperature: " . $request->get('temperature_at_home') . '°C, ' .
            "Humidity: " . $request->get("humidity_at_home") . ' % ' .
            "Pressure: " . $request->get('pressure_at_home') . ' hPa ' .
            "Light intensity: " . $request->get('light_intensity_at_home') . 'lux '
        );
        return response()->json([
            'status' => true,
            'message' => 'Log was saved successfully'
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\HomeWeatherLog  $homeWeatherLog
     * @return \Illuminate\Http\JsonResponse
     */
    public function showCurrentHomeWeatherData(HomeWeatherLog $homeWeatherLog)
    {
        return response()->json([
            'status' => true,
            'data' => HomeWeatherLog::latest('created_at')->first()
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\HomeWeatherLog  $homeWeatherLog
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, HomeWeatherLog $homeWeatherLog)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\HomeWeatherLog  $homeWeatherLog
     * @return \Illuminate\Http\Response
     */
    public function destroy(HomeWeatherLog $homeWeatherLog)
    {
        //
    }
}
