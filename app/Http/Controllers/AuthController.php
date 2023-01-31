<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use Illuminate\Support\Facades\Hash;



// use Illuminate\Http\Request;
use Illuminate\Http\Response;


class AuthController extends Controller
{
    public function register(Request $request)
    {
        $fields = $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|unique:users,email',
            'phone' => 'required|string|unique:users,phone',
            'password' => 'required|string|confirmed'
        ]);

        $user = User::create([
            'name' => $fields['name'],
            'email' => $fields['email'],
            'phone' => $fields['phone'],
            'password' => bcrypt($fields['password'])
        ]);

        $token = $user->createToken('myapptoken')->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token
        ];

        return response($response, 201);// everything was successfull
    }

    public function login(Request $request) {
        $fields = $request->validate([
            'email' => 'required|string',
            'password' => 'required|string'
        ]);

        // Check email
        $user = User::where('email', $fields['email'])->first();

        // Check password
        if(!$user || !Hash::check($fields['password'], $user->password)) {
            return response([
                'message' => 'Invalid Credentials'
            ], 401);
        }

        $token = $user->createToken('myapptoken')->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token
        ];

        return response($response, 201);
    }



    public function logout(Request $request)
    {
        auth()->user()->tokens()->delete();

        return [
            'message' => 'Logged out'
        ];
    }
}















// class AuthController extends Controller
// {
//     public function register(Request $request)
//     {
//         $fields = $request->validate([
//             'name' => 'required|string',
//             'email' => 'required|string|unique:users,email',
//             'phone' => 'required|string|unique:users,phone',
//             'password' => 'required|string|confirmed'
//         ]);

//         $user = User::create([
//             'name' => $fields['name'],
//             'email' => $fields['email'],
//             'phone' => $fields['phone'],
//             'password' => bcrypt($fields['password'])
//         ]);

//         $token = $user->createToken('myapptoken')->plainTextToken;

//         $response = [
//             'user' => $user,
//             'token' => $token
//         ];

//         return response($response, 201);
//     }

//     public function login(Request $request) {
//         $fields = $request->validate([
//             'email_or_phone' => 'required|string',
//             'password' => 'required|string'
//         ]);

//         $user = User::where('email', $fields['email_or_phone'])->orWhere('phone', $fields['email_or_phone'])->first();

//         if(!$user || !Hash::check($fields['password'], $user->password)) {
//             return response([
//                 'message' => 'Invalid Credentials'
//             ], 401);
//         }

//         $token = $user->createToken('myapptoken')->plainTextToken;

//         $response = [
//             'user' => $user,
//             'token' => $token
//         ];

//         return response($response, 201);
//     }

//     public function logout(Request $request)
//     {
//         auth()->user()->tokens()->delete();

//         return [
//             'message' => 'Logged out'
//         ];
//     }
// }