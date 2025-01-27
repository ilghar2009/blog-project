<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Contracts\JWTSubject;

class UserController extends Controller
{
    public function index(){
        return User::all();
    }

    public function store(Request $request){
        $validate = $request->validate([
            'name' => ['required', 'string', 'max:80', 'min:3'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone' => ['required', 'string', 'min:11', 'max:11', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'same:password'],
        ]);

        if($validate->errors){
            return $validate->errors;
        }

        else {
            $password = Hash::make($request->password);
            User::created([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'password' => $password,
                'role' => '1',
            ]);

            return 'success';
        }

    }

    public function edit(User $user){
        return $user;
    }

    public function update(Request $request, User $user){

        $validate = $request->validate([
            'name' => ['required', 'string', 'max:80', 'min:3'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone' => ['required', 'string', 'min:11', 'max:11', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'same:password'],
        ]);

        if($validate->errors){
            return $validate->errors;
        }
        else {
            $user = User::where('name', $request->name)
                ->where('email', $request->email)
                ->where('phone', $request->phone)->first();

            $user->updated([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'role' => $request->role??'1',
            ]);

            return 'success';
        }
    }

    public function login(Request $request){

        $user = User::where('email', $request)
            ->where('phone', $request->phone)->first();

        if($user){
            if(Hash::check($request->password, $user->password)) {
                Auth::login($user);
                return 'success';
            }
            else
                return false;
        }

    }

    public function destroy(User $user){
        $user->delete();
        return 'success';
    }

    public function search(Request $request){
        $users = User::where('name', 'LIKE', '%'.$request->search.'%')->first();
        return $users;
    }

}
