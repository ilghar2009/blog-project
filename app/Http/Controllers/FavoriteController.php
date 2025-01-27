<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Favorite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;

class FavoriteController extends Controller
{
    public function index(){
        // get information user
            $user = JWTAuth::parseToken()->authenticate();
            $cart = Cart::where('user_id', $user->user_id)->first();

        // get favorite blog of user
            $favorite = Favorite::where('user_id', $cart->carts_id)->get();

        return $favorite??'none';

    }

    public function store(Request $request){
        //get user_id of cart
            $user = JWTAuth::parseToken()->authenticate();
            $cart = Cart::where('user_id', $user->user_id)->first();

         //check favorite for unique
            $check_favorite = Favorite::where('blog_id', $request->blog_id)->where('user_id', $cart->carts_id)->get();

        //create favorite with blog
            if(!count($check_favorite)){
                Favorite::create([
                    'user_id' => $cart->carts_id,
                    'blog_id' => $request->blog_id,
                ]);
            }

        return true;

    }

    public function destroy(Request $request){

        // get user information
            $user = JWTAuth::parseToken()->authenticate();
            $cart = Cart::where('user_id', $user->user_id)->first();

        //search and delete
            Favorite::where('user_id', $cart->carts_id)->where('blog_id', $request->blog_id)->delete();

        return True;
    }
}
