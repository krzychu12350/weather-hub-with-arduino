<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\FavouritePlace;
use Tymon\JWTAuth\Contracts\Providers\Auth;

class FavouritePlaceController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $favouritePlaces = FavouritePlace::all();

        return response()->json([
            "status" => true,
            "message" => "Places List",
            "data" => $favouritePlaces
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
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

        $favouritePlace = FavouritePlace::create($request_data);


        //Current Auth User provides token
        //dd(User::find(auth('api')->user()->getAuthIdentifier()));
        $favouritePlace->users()->attach(User::find(auth('api')->user()->getAuthIdentifier()));

        //dd($favouritePlace->);


        return response()->json([
            "status" => true,
            "user_id" => auth('api')->user()->getAuthIdentifier(),
            "message" => "FavouritePlace created successfully.",
            "data" => $favouritePlace
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(int $id)
    {
        $favouritePlace = FavouritePlace::find($id);
        if (is_null($favouritePlace)) {
            return response()->json([
                'status' => false,
                'message' => 'FavouritePlace not found'
            ]);
        }

        return response()->json([
            "success" => true,
            "message" => "FavouritePlace found.",
            "data" => $favouritePlace
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, FavouritePlace $favouritePlace)
    {
        $request_data = $request->all();

        $validator = Validator::make($request_data, [
            'id' => 'required',
            'name' => 'required',
            'state' => '',
            'country' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Invalid Inputs',
                'error' => $validator->errors()
            ]);
        }

        $favouritePlace->id = $request_data['id'];
        $favouritePlace->name = $request_data['name'];
        $favouritePlace->state = $request_data['state'];
        $favouritePlace->country = $request_data['country'];
        $favouritePlace->save();

        return response()->json([
            "status" => true,
            "message" => "FavouritePlace updated successfully.",
            "data" => $favouritePlace
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(FavouritePlace $favouritePlace)
    {
        $favouritePlace->delete();
        return response()->json([
            "status" => true,
            "message" => "FavouritePlace deleted successfully.",
            "data" => $favouritePlace
        ]);
    }
}
