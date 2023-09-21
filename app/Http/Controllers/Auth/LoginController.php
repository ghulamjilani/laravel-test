<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;

//custom class for response
use App\Http\Responses\Message;
use App\Http\Responses\ResponseCode;

class LoginController extends Controller
{
    // check credentials if they are valid then create token.
    public function loginPage(Request $request)
    {
        return view('login');
    }

    // check credentials if they are valid then create token.
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $result = [
                'access_token'  => auth()->user()->createToken('authToken')->plainTextToken, 
                'token_type'    => 'Bearer'
            ];

            $request->session()->flash('access_token', $result['access_token']);
            // return redirect()->route('products.list');
            return makeResponse(ResponseCode::SUCCESS, ResponseCode::getMessage(ResponseCode::SUCCESS), $result, ResponseCode::SUCCESS);
        }
        // return back()->withError('Invalid email or password.')->withInput($request->only('email', 'remember'));
        return makeResponse(ResponseCode::INVALID_CREDENTIALS, ResponseCode::getMessage(ResponseCode::INVALID_CREDENTIALS), [], ResponseCode::INVALID_CREDENTIALS);
    }
    
    // logout function
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        
        return makeResponse(ResponseCode::LOGOUT_SUCCESS, ResponseCode::getMessage(ResponseCode::LOGOUT_SUCCESS), [], ResponseCode::LOGOUT_SUCCESS);
    }
}