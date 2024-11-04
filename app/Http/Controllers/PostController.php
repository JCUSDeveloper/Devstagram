<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Posts;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class PostController extends Controller
{
    //
    public function index(User $user){

        $posts = Posts::where('user_id', $user->id)->paginate(12);

        return view('dashboard', [
            'user' => $user,
            'posts' => $posts
        ]);//pasar datos a la vista
    }

    public function create(){//tener la vista del formulario
        return view('/posts/create');
    }

    public function store(Request $request){ //es post, asi que guarda a la base de datos
        //otra manera de registrarlo
        
        $validatedData = $request->validate([
            'titulo' => 'required|max:255',
            'descripcion' => 'required',
            'imagen' => 'required'
        ]);

        $validatedData['user_id'] = auth('web')->user()->id; 
        
        Posts::create($validatedData);

        return redirect()->route('posts.index', auth('web')->user()->username);
    }

    public function show(User $user, Posts $post){
        return view('posts.show',[
            'post' => $post,
            'user' => $user
        ]);
    }

    public function destroy(Posts $post){

       if($post->user_id === auth('web')->user()->id){
            $post->delete();
            
            $imagen_path = public_path('uploads/' . $post->imagen);
            
            if(File::exists($imagen_path)){
                unlink($imagen_path);    
            }
       }else{
            dd('autenticate');
       }
       return redirect()->route('posts.index', auth('web')->user()->username);
      
    }
    
}
