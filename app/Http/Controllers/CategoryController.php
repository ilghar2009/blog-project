<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    public function index(Request $request){

        if(isset($request->search)) {
            $category = Category::where('title', 'LIKE', '%'.$request->search.'%')->get();
        }else
            $category = Category::all();

        return $category;
    }

    public function store(Request $request){
        $file = $request->image;

        if($request->image){

            $filename = $file->getClientOriginalName();

            Storage::disk('local')
                ->put('public/img/' . $filename, file_get_contents($file));

            $fileUrl = Storage::disk('local')->url('public/img/' . $filename);
        }else{
            $fileUrl = null;
        }

        Category::create([
            'title' => $request->title,
            'image' => $fileUrl,
        ]);

        return True;
    }


    public function update(Request $request,Category $category){
        $file = $request->image;

        if($request->image){

            $filename = $file->getClientOriginalName();

            Storage::disk('local')
                ->put('public/img/' . $filename, file_get_contents($file));

            $fileUrl = Storage::disk('local')->url('public/img/' . $filename);
        }else{
            $fileUrl = $category->image;
        }

        $category->update([
            'title' => $request->title,
            'image' => $fileUrl,
        ]);

        return true;
    }

    public function destroy(Category $category){
        $category->delete();
        return true;
   }

}
