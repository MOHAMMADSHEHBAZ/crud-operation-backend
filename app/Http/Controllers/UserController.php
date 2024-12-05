<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
{
    return User::all();
}

public function CreateUser(Request $request)
{
    if($request->rid == "add"){
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users,email',
        'password' => 'required|string|min:8',
    ]);

    try {
        $user = DB::table('users')->insert([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'status' => 1,
            // changes
        ]);
        
        if ($user) {
            return response()->json(['message' => 'User created successfully!'], 201);
        } else {
            return response()->json(['user'=>$user,'message' => 'Failed to create user.'], 400);
        }
    } catch (\Exception $e) {
        return response()->json(['message' => 'Database Error: ' . $e->getMessage()], 500);
    }}
    else{
        try {
        $user = DB::table('users')
        ->where('id',$request->rid)
        ->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'status' => $request->rid,
        ]);
        
        if ($user) {
            return response()->json(['message' => 'User Updated successfully!'], 201);
        } else {
            return response()->json(['user'=>$user,'message' => 'Failed to create user.'], 400);
        }
    } catch (\Exception $e) {
        return response()->json(['message' => 'Database Error: ' . $e->getMessage()], 500);
    }
    }
}

public function getUsers(Request $request)
{
    $data = DB::table('users')
    ->orderBy('id', 'desc') 
    ->paginate(5);
    return response()->json($data);
}

public function getUsersDetails($id)
{   
    $data = DB::table('users')
    ->where('id',$id)
    ->get();
    return response()->json($data);
}


public function getUsersCount(Request $request)
{
    $data = DB::table('users')->count();
    return response()->json($data);
}

}
