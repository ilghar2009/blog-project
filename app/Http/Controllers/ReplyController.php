<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Comment;
use Illuminate\Http\Request;

class ReplyController extends Controller
{
    public function reply(Request $request){
        //user
            $user = JWTAuth::parseToken()->authenticate();
            $cart = Cart::where('user_id',$user->user_id)->first();

        //comments
            $comments = Comment::where('reply', $cart->carts_id)->get();

            return $comments;
    }
}
