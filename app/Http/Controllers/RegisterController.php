<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    //
    public function index() {
        return view('auth.register');
    }

    public function store(Request $request){
        //dd($request);

        //dd($request -> get('username'));

        //Validacion

        $request -> validate([
            'name' => 'required|max:30|min:5',
            'username' => 'required|unique:users|min:3|max:30',
            'email' => 'required|unique:users|email|min:3|max:30',
            'password' => 'required|confirmed|min:6'
        ]);


        User::create([
            'name' => $request -> name,
            'username' => Str::slug($request -> username),
            'email' => $request -> email,
            'password' => $request -> password
        ]);


        //Autenticar 
        auth('web')->attempt([
            'email' => $request->email,
            'password' => $request->password
        ]);

        //Otra forma de autenticar
        //auth('web')->attempt($request->only('email', 'password'));
       
       return redirect()->route('posts.index', auth('web')->user());
    }

}

