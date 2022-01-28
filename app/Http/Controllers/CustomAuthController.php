<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Hash;
use Session;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class CustomAuthController extends Controller
{
    public function customLogin(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $success['token'] = $user->createToken('SanctumAPI')->plainTextToken;
            return response()->json(['success'=>$success], 201); 
        }
        return response()->json([
            'message' => 'Login details are not valid'
        ], 201);
    }

    public function customRegistration(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'lastname' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
        ]);

        $data = $request->all();
        $check = $this->create($data);
        $token = $check->createToken('SanctumAPI');
        $success['token'] = $check->createToken('SanctumAPI')->plainTextToken;
        return response()->json(['success'=>$success], 201); 
    }


    public function create(array $data)
    {
      return User::create([
        'name' => $data['name'],
        'email' => $data['email'],
        'lastname' => $data['lastname'],
        'password' => Hash::make($data['password'])
      ]);
    }

    public function signOut() {
        auth()->user()->tokens()->delete();
        return response()->json(['message'=>'Success'], 201);
    }

    public function ShowUserlist(){
        $users = User::all();
        return response()->json([$users], 201);
    }
}