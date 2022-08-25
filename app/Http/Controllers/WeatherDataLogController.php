<?php

namespace App\Http\Controllers;

use App\Models\WeatherDataLog;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class WeatherDataLogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        $user = auth('api')->user()->getAuthIdentifier();
        $authUserWeatherDataLogsForFavouritePlaces = auth('api')->user()
            ->with(['favouritePlaces' => function ($query) {
                $query->with(['weatherDataLogs' => function ($query) {
                    $place_created_at = auth('api')->user()->favouritePlaces()
                        ->first();
                    $query->where('created_at', '>=', $place_created_at->pivot->created_at);
                }]);
            }])
            ->find($user);

        return response()->json([
            'status' => true,
            'data' => $authUserWeatherDataLogsForFavouritePlaces,
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        $request_data = $request->all();

        $validator = Validator::make($request_data, [
            'temperature' => 'required|integer',
            'humidity' => 'required|integer|min:0|max:100',
            'favourite_place_id' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Invalid Inputs',
                'error' => $validator->errors()
            ]);
        }
        //dd($request_data, $request_data['favourite_place_id']);
        $weatherDataLog = new WeatherDataLog;
        $weatherDataLog->temperature = $request_data['temperature'];
        $weatherDataLog->humidity = $request_data['humidity'];
        $weatherDataLog->favouritePlace()->associate($request_data['favourite_place_id']);
        $weatherDataLog->save();
        //$weatherDataLog = WeatherDataLog::create($request_data);

        return response()->json([
            "success" => true,
            "message" => "Weather data log was saved successfully.",
            "data" => $weatherDataLog,
        ]);
    }
}
