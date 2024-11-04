<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Posts;
use App\Models\Comments;
use Illuminate\Http\Request;

class CommentsController extends Controller
{
    //

    public function store(Request $request, User $user, Posts $post){
        
        $validatedData = $request->validate([
            'comentario' => 'required|max:255'
        ]);
        
        $validatedData['user_id'] = auth('web')->user()->id; 
        $validatedData['post_id'] = $post->id; 
        $validatedData['comentario'] = $request->comentario;
        
        Comments::create($validatedData);

        return back()->with('mensaje', 'Comentario Realizado Correctamente');
    }

}
