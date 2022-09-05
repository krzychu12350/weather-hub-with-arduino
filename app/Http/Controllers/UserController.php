<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Get an authenticated user with its favourite places.
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return response()->json([
            'status' => true,
            'message' => 'User found',
            'data' => auth('api')->user()
                ->with('favouritePlaces')
                ->find(auth()->id())
        ], 200);
    }

    /**
     * Update user's primary place
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return JsonResponse
     */
    public function updateUserPrimaryPlace(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'primary_place_id' => 'required|string|min:1',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Invalid place id',
                'error' => $validator->errors(),
            ], 422);

        }
        $user = User::find(auth('api')->user()->getAuthIdentifier());
        $user->primary_place_id = $request->primary_place_id;
        $user->save();
        //dd($user);
        return response()->json([
            'status' => true,
            'message' => 'User primary place was updated successfully',
            'data' => auth('api')->user(),
        ], 200);
    }

    /**
     * Remove a user from database.
     *
     * @return JsonResponse
     */
    public function destroy()
    {
        $user = User::findOrFail(auth('api')->user()->getAuthIdentifier());
        if($user) {
            $user->delete();
            return response()->json([
                "status" => true,
                "message" => "The user account was deleted successfully",
            ], 200);
        }
    }
}
