<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

//custom class for response
use App\Http\Responses\Message;
use App\Http\Responses\ResponseCode;

// Models
use App\Models\User;

class UserController extends Controller
{
    // register New user
    public function register(Request $request){
        $data = $request->validate([
            'username'  => 'required|unique:users',
            'email'     => 'required|unique:users',
            'password'  => 'required|confirmed',
            'role'      => 'in:admin,moderator',
        ]);
    
        $userData = array_merge($data, ['role' => $data['role'] ?? 'admin']);
    
        $user = User::create($userData);
        $token = $user->createToken('my-token')->plainTextToken;
    
        return response()->json([
            'token' =>$token,
            'Type' => 'Bearer'
        ]);
    }

    public function profile(Request $request)
    {
        try
        {
            $user = User::with('Role')->find(auth()->id());
            if(!$user)
                return makeResponse(ResponseCode::UNAUTHORIZED, ResponseCode::getMessage(ResponseCode::UNAUTHORIZED), [], ResponseCode::UNAUTHORIZED);
            else
                return makeResponse(ResponseCode::SUCCESS, ResponseCode::getMessage(ResponseCode::SUCCESS), $user, ResponseCode::SUCCESS);
        }
        catch (\Exception $e) {
            return makeResponse(ResponseCode::UNEXPECTED_ERROR, ResponseCode::getMessage(ResponseCode::UNEXPECTED_ERROR), [], ResponseCode::UNEXPECTED_ERROR, $e->getMessage());
        }
    }

}
