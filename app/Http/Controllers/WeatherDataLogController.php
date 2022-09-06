<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;

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
}
