<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Cart;
use App\Models\Comment;
//use Illuminate\Container\Attributes\Auth;
use App\Models\Favorite;
use App\Models\Show;
use App\Models\View;
use App\Models\Viewblog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;

class ShowController extends Controller
{
    public function index(Request $request){

        //search blogs with title category_id & tow

            if(isset($request->title)){
                $blogs = Blog::where('title', 'LIKE', '%'.$request->title.'%')->where('role', 'Public')->get();

            }elseif(isset($request->category_id))
                $blogs = Blog::where('category_id', $request->category_id)->where('role', 'Public')->get();

            elseif($request->title and $request->category_id)
                $blogs = Blog::where('category_id', $request->category_id)->where('title', 'LIKE', '%'.$request->title.'%')->where('role', 'Public')->get();

            else
                $blogs = Blog::where('role', 'Public')->get();

        return $blogs;
    }

    public function show($id, Request $request){

        // get blogs and it's comments
            $blog = Blog::where('blog_id', $id)->where('role', 'Public')->first();
            $comment = Comment::where('blog_id', $id)->where('role', 'Public')->get();

        // check user show and create it's
            $show = Show::where('blog_id', $id)->first();

            if (!isset($show)) {
                Show::create([
                    'blog_id' => $id,
                ]);

                $show = Show::where('blog_id', $id)->first();
            }

        //Auth check
            $token = $request->header('Authorization');

            if ($token){

        //get user information
                $user = JWTAuth::parseToken()->authenticate();
                $cart = Cart::where('user_id', $user->user_id)->first();

        //check blog role('result')
                if ($blog) {

                    $view = View::where('blog_id', $show->id)
                        ->where('user_id', $cart->carts_id)->first();

                    if ($view)
                        $view->update([
                            'quantity' => $view->quantity + 1,
                        ]);

                    else{
                        View::create([
                            'blog_id' => $show->id,
                            'user_id' => $cart->carts_id,
                            'quantity' => 1,
                        ]);
                    }
            }
        }else{
            View::create([
                'blog_id' => $show->id,
                'user_id' => 0,
                'quantity' => 1,
            ]);
        }


        $view = View::all()->count();

        return [$blog, $comment, $view];
    }

}
