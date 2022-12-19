<?php

namespace App\Http\Controllers;

use App\Models\HomeWeatherLog;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
        $homeWeatherDataLogsByEveryHour = DB::table('home_weather_logs')->where('created_at',
            '>=', Carbon::now()->subDay()->toDateTimeString())
            ->select(DB::raw('hour(created_at) as certain_hour'),
                DB::raw('ROUND(AVG(temperature_at_home), 0) as temperature_at_home'),
                DB::raw('ROUND(AVG(humidity_at_home), 0) as humidity_at_home'),
                DB::raw('ROUND(AVG(pressure_at_home), 0) as pressure_at_home'),
                DB::raw('ROUND(AVG(light_intensity_at_home), 0) as light_intensity_at_home'))
            ->groupBy(DB::raw('hour(created_at)'))
            ->get();

        return response()->json([
            'status' => true,
            'data' => $homeWeatherDataLogsByEveryHour
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
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
        $createdHomeWeatherLog = HomeWeatherLog::create($request_data);

        return response()->json([
            'status' => true,
            'message' => 'Log was saved successfully',
            'log' => $createdHomeWeatherLog
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\HomeWeatherLog $homeWeatherLog
     * @return \Illuminate\Http\JsonResponse
     */
    public function showCurrentHomeWeatherData(HomeWeatherLog $homeWeatherLog)
    {
        return response()->json([
            'status' => true,
            'data' => HomeWeatherLog::latest('created_at')->first()
        ], 200);
    }
}
