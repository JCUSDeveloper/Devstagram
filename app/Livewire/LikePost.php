<?php

namespace App\Livewire;

use Livewire\Component;

class LikePost extends Component
{
    public $post;

    public $isLiked;

    public $count;

    public function mount($post){
        $this->isLiked = $post->checklike(auth('web')->user());
        $this->count=$post->likes->count();
    }

    public function like(){
        if($this->post->checklike(auth('web')->user() )){
           $this->post->likes()->where('post_id', $this->post->id)->delete();
           $this->isLiked = false;
           $this->count --;
        }else{
            $this->post->likes()->create([
                'user_id' => auth('web')->user()->id
            ]);
            $this->isLiked = true;
            $this->count ++;
        }
    }

    public function render()
    {
        return view('livewire.like-post');
    }
}
