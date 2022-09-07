<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Carbon;

class WeatherDataLogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        $userId = auth('api')->user()->getAuthIdentifier();
        $authUserWeatherDataLogsForFavouritePlaces = auth('api')->user()
            ->with(['favouritePlaces' => function ($query) {
                $query->with(['weatherDataLogs' => function ($query) {
                    $userFavouritePlaces = auth('api')->user()->favouritePlaces()->get();
                    foreach($userFavouritePlaces as $place)
                        $query->where('created_at', '>=', $place->pivot->created_at);
                }]);
            }])
            ->find($userId);

        return response()->json([
            'status' => true,
            'data' => $authUserWeatherDataLogsForFavouritePlaces,
        ], 200);
    }
}
