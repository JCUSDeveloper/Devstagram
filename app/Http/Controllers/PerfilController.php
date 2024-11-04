<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class PerfilController extends Controller
{
    //
    public function index(){
        return view('profile.index');
    }

    public function store(Request $request){

        $validatedData = $request->validate([
            'username' => [
                'required', 'unique:users,username,' . auth('web')->user()->id, 'min:3','max:30', 'not_in:twitter,editar-perfil'],
        ]);

        $validatedData['username'] = Str::slug($validatedData['username']);

        if($request->imagen){
            $imagen = $request -> file('imagen');

            $nombreImagen = Str::uuid().".".$imagen->extension();

            $imagenServidor = Image::make($imagen);
            $imagenServidor->fit(1000,1000);

            $imagenPath = public_path('profiles') . '/' . $nombreImagen;
            $imagenServidor -> save($imagenPath);

        }
        //Guardar cambios
        $usuario = User::find(auth('web')->user()->id);
        $usuario->username = $request->username;
        $usuario->imagen = $nombreImagen ?? auth('web')->user()->imagen ?? null;
        $usuario->save();

        //Redireccionar
        return redirect()->route('posts.index', $usuario->username);
    }
}
