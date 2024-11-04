<?php

namespace App\Http\Controllers;

use App\Models\Follower;
use App\Models\User;

class FollowerController extends Controller
{
    //
    public function store(User $user){
        if($user->followers->contains(auth('web')->user()->id)){
            return back();
        }
        $user->followers()->attach( auth('web')->user()->id);

        return back();
    }

    public function destroy(User $user){
        $user->followers()->detach( auth('web')->user()->id);

        return back();
    }
}
