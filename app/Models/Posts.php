<?php

namespace App\Models;

use App\Models\Like;
use App\Models\Comments;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Posts extends Model
{
    use HasFactory;

    protected $fillable = [
        'titulo',
        'descripcion',
        'imagen',
        'user_id'
    ];

    public function user(){
        return $this->belongsTo(User::class)->select(['name', 'username']);
    }

    public function comentarios(){
        return $this->hasMany(Comments::class, 'post_id');
    }

    public function likes(){
        return $this->hasMany(Like::class, 'post_id');
    }

    public function checklike(User $user){
        return $this->likes->contains('user_id', $user->id);
    }
}
