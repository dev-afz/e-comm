<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\User as ModelsUser;
use App\Models\Api\User as ApiUser;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class User extends Controller
{
    //get all user details
    public function user()
    {
        return response(ApiUser::where('status', 1)->get(), 200);
    }
    //get user details by id
    public function userById($id)
    {
        $user = ApiUser::find($id);
        if (is_null($user)) {
            return response()->json(["message" => 'Record not found!'], 404);
        }
        return response()->json($user, 200);
    }
    //user register
    public function userstore(Request $request)
    {
        $password = Hash::make($request->password);
        $request->validate([
            'name' => 'required',
            'email' => 'required',
        ]);
        $user = ApiUser::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $password
        ]);
        return response()->json($user, 201);
    }
    //update user details
    public function update(Request $request)
    {
        $password = Hash::make($request->password);
        $user = ApiUser::find($request->id);
        if (is_null($user)) {
            return response()->json(["message" => 'Record not found!'], 404);
        }
        $user->name = $request['name'];
        $user->email = $request['email'];
        $user->password = $password;
        $user->save();
        return response()->json($user, 200);
    }
    //delete user
    public function delete(Request $request)
    {
        $delete = ApiUser::find($request->id);
        if (is_null($delete)) {
            return response()->json(["message" => 'Record not found!'], 404);
        }
        $delete->delete();
        return response()->json(null, 204);
    }
}
