<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    //handle the registration api request
    public function register(Request $request)
    {
        if($request->isMethod('post')){
            //validate the request
            $this->validate($request, [
                // 'name' => 'required',
                'email' => 'required|email|unique:users',
                'password' => 'required|confirmed|min:6',
            ]);

            //create the user
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = bcrypt($request->password);
            $saved = $user->save();

            $token = $user->createToken('MyApp')->accessToken;

          if($saved){
            return response()->json(['success' => true, 'message' => 'User registered successfully', 'token' => $token]);
            }else{
            return response()->json(['success' => false, 'message' => 'User registration failed']);
            }
        }

    }

    //handle the login api request
    public function login(Request $request)
    {
        //validate the request
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        //check if the user exists
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => 'User does not exist!'
            ], 401);
        }

        //check if the password is correct
        if (!Hash::check($request->password, $user->password)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Password is incorrect!'
            ], 401  );
        }

        //generate the token
        $token = $user->createToken($user->name)->accessToken;

        //return the response
        return response()->json([
            'status' => 'success',
            'message' => 'Successfully logged in!', 
            'data' => $user,
            'token' => $token

        ], 200);
    }

    //handle the user profile api request
    public function profile(Request $request)
    {
        //if 302 is returned, the user is not logged in
    
            return response()->json([
                'status' => 'success',
                'message' => 'Successfully got the user profile!',
                'data' => auth()->user()
            ], 200);
        

    }

    //handle the user logout api request
    public function logout(Request $request)
    {
        $token = $request->user()->token();
        $token->revoke();

        return response()->json([
            'message' => 'Successfully logged out!'
        ], 200);
    }
    
}
