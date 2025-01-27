<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Tymon\JWTAuth\Facades\JWTAuth;

class CommentController extends Controller
{
    public function index(){

        return Comment::all();

    }

    public function store(Request $request){
        $user = JWTAuth::parseToken()->authenticate();

        $cart = Cart::where('user_id', $user->user_id)->first();

        Comment::create([
            'created_by' => $cart->carts_id,
            'text' => $request->text,
            'role' => $request->role??'Draft',
            'blog_id' => $request->blog_id,
            'reply' => $request->reply??0,
        ]);

        return true;
    }

    public function update(Request $request, Comment $comment){
        $comment->update([
            'role' => $request->role??'Draft',
        ]);

        return true;
    }

    public function destroy(Comment $comment){
        $comment->delete();
        return True;
    }
}
