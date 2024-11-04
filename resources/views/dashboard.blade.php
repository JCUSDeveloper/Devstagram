@extends('layouts.app')

@section('titulo')
    Perfil: {{$user-> username}}
@endsection

@section('contenido')
    <div class="flex justify-center">
        <div class="w-full md:w-8/12 lg:w-6/12 flex flex-col items-center md:flex-row">
            <div class="w-8/12 lg:w-6/12 px-5">
                <img src="{{ $user->imagen ? asset('profiles') . '/' . $user->imagen : asset('img/usuario.svg')}}" alt="imagenUsuario" >
            </div>

            <div class="md:w-8/12 lg:w-6/12 px-5 flex flex-col items-center md:justify-center md:items-start py-10 md:py-10">

                <div class="flex items-center gap-2 p-3">
                    <p class="font-bold">{{ $user ->username }}</p>
                    
                    @auth
                        
                        @if ($user->id === auth()->user()->id)

                            <a 
                                href="{{ route('perfil.index') }}"
                                class="text-gray-500 hover:text-gray-600 cursor-pointer">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" width="24" height="24" stroke-width="2"> 
                                    <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1"></path> 
                                    <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z"></path> 
                                    <path d="M16 5l3 3"></path> 
                                </svg> 
                            </a>

                        @endif    
                    
                    @endauth
                </div>

                <p class="text-gray-800 text-sm mb-3 font-bold">
                    {{ $user->followers->count()}}
                    <span class="font-normal">@choice('Seguidor|Seguidores', $user->followers->count())</span>
                </p>

                <p class="text-gray-800 text-sm mb-3 font-bold">
                    {{$user->following->count()}}
                    <span class="font-normal">Siguiendo</span>
                </p>

                <p class="text-gray-800 text-sm mb-3 font-bold">
                    {{ $user->posts->count() }}
                    <span class="font-normal">Posts</span>
                </p>
                @auth
                    @if($user->id !== auth()->user()->id)
                        @if( !$user->siguiendo(auth()->user()) )
                            <form action=" {{ route('users.follow', $user) }}" method="POST">
                                @csrf
                                <input type="submit"
                                    class="bg-blue-600 text-white uppercase rounded-lg px-3 py-2 text-xs font-bold cursor-pointer"
                                    value="Seguir">
                            </form>
                        @else
                            <form action=" {{ route('users.unfollow', $user)}}" method="POST">
                                @method('DELETE')
                                @csrf
                                <input type="submit"
                                    class="bg-red-600 text-white uppercase rounded-lg px-3 py-2 text-xs font-bold cursor-pointer"
                                    value="Dejar de Seguir">
                            </form>
                        @endif 
                    @endif
                @endauth
            </div>

        </div>

    </div>


    <section class=" container mx-auto mt-10">
        <h2 class="text-4xl text-center font-black my-10"> Publicaciones </h2>   
            <x-listar-post :posts="$posts"/> 
        </section>
@endsection