<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\FavouritePlace;

class FavouritePlaceController extends Controller
{
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
            'id' => 'required',
            'name' => 'required',
            'state' => 'nullable',
            'country' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Invalid Inputs',
                'error' => $validator->errors()
            ]);
        }

        $isFavouritePlaceExist = FavouritePlace::where('id', $request->id)->doesntExist();

        if ($isFavouritePlaceExist)
            $favouritePlace = FavouritePlace::create($request_data);
        else
            $favouritePlace = FavouritePlace::findOrFail($request->id);

        $user = User::findOrFail(auth('api')->user()->getAuthIdentifier());
        $isAlreadyUserFavouritePlace =
            $user->favouritePlaces()->whereId($request->id)->exists();

        if ($isAlreadyUserFavouritePlace)
            $responseMessage = "You have already added this place to the watched places!!!";
        else
            $responseMessage = "FavouritePlace added successfully!!!";

        $favouritePlace->users()->syncWithoutDetaching($user);

        return response()->json([
            "status" => true,
            "user_id" => auth('api')->user()->getAuthIdentifier(),
            "message" => $responseMessage,
            "data" => $favouritePlace
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id)
    {
        $user = User::find(auth('api')->user()->getAuthIdentifier());
        $user->favouritePlaces()->detach($id);
        return response()->json([
            "status" => true,
            "message" => "This place was deleted successfully from your favourite places!!!",
        ]);
    }
}
