<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\User;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;
use function PHPUnit\Framework\isEmpty;


class AuthController extends Controller
{
    /**
     * @throws BindingResolutionException
     */
    public function sign(Request $request){

        $validate = validator()->make($request->all(),[
            'name' => ['required', 'string', 'min:3'],
            'email' => ['required', 'email', 'unique:users'],
            'phone' => ['required', 'min:11', 'max:11', 'starts_with:09','unique:users'],
            'password' => ['required', 'min:8', 'confirmed'],
            'password_confirmation' => ['required', 'min:8', 'same:password'],
        ]);


        if($validate->errors()->messages())
            return  $validate->errors()->messages();
        else {
            $password = Hash::make($request->password);

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'password' => $password,
                'role' => 1,
            ]);

            Cart::create([
                'user_id' => $user->user_id,
            ]);

            Auth::login($user);
            $token = JWTAuth::fromUser($user);

            return response()->json([
                'token' => $token,
                'user' => $user,
            ]);
        }
    }

    public function login(Request $request){

        $check_user = $request->only('email', 'password');

        if(!Auth::attempt($check_user))
            return response()->json(['error' => 'Unauthorized']);

        else {
            $user = Auth::user();
            $token = JWTAuth::fromUser($user);

            $cart = Cart::where('user_id', $user->user_id)->first();

            if(!$cart)
                Cart::create([
                    'user_id' => $user->user_id,
                ]);

            return response()->json([
                'token' => $token,
                'user' => $user,
            ]);
        }
    }
}
