<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Cart;
use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Tymon\JWTAuth\Facades\JWTAuth;

class BlogController extends Controller
{
    public function index(Request $request){
        $search = $request->search??null;
        $filter = $request->filter??null;

        if($filter && $search){
            $blogs = Blog::where('title','Like','%'.$search.'%')->where('category_id', $filter)->get();
        }elseif($search){
            $blogs = Blog::where('title','Like','%'.$search.'%')->get();
        }elseif($filter){
            $blogs = Blog::where('category_id', $filter)->get();
        }else
            $blogs = Blog::all();

        return $blogs;
    }

    public function store(Request $request){
        $user = JWTAuth::parseToken()->authenticate();
        $cart = Cart::where('user_id', $user->user_id)->first();

        $blog = Blog::create([
            'title' => $request->title,
            'text' => $request->text,
            'category_id' => $request->category_id,
            'role' => $request->role??'Draft',
            'created_by' => $cart->carts_id,
            'updated_by' => $cart->carts_id,
        ]);

        return $blog;
    }

    public function update(Request $request, Blog $blog){
        $user = JWTAuth::parseToken()->authenticate();

        $cart = Cart::where('user_id', $user->user_id)->first();

        $blog->update([
            'title' => $request->title??$blog->title,
            'text' => $request->text??$blog->text,
            'created_by' => $blog->created_by,
            'role' => $request->role??'Draft',
            'updated_by' => $cart->carts_id,
        ]);

        return True;
    }

    public function destroy(Blog $blog){
        $blog->delete();

        return True;
    }

}
