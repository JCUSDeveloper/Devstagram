<?php

namespace App\Http\Controllers;

use App\Models\Posts;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    //
    public function __invoke()
    {
        //Obtener los que seguimos
       $ids = auth('web')->user()->following->pluck('id')->toArray();
       $posts = Posts::whereIn('user_id', $ids)->latest()->paginate(20);
       return view('home', [ 'posts' => $posts ]);
    }
}
