<?php

namespace App\Http\Controllers;

use App\Models\Posts;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    //
    public function store(Request $request, Posts $post){

        $post->likes()->create([
            'user_id' => $request->user()->id
        ]);

        return back();
    }

    public function destroy(Request $request, Posts $post){
        
        $request->user()->likes()->where('post_id', $post->id)->delete();
        return back();
    }
}
