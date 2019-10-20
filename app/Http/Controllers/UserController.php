<?php

namespace App\Http\Controllers;

use App\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

use App\Video;
use App\Comentario;
use App\User;

class UserController extends Controller
{
    public function channel($user_id)
    {
        $user = User::find($user_id);

        //dd($user);


        if(!$user){

            return redirect()->route('home')->with(['message' => 'El usuario con id' . $user_id . ' No exsite']);
        }
        $videos = Video::where('user_id', $user_id)->paginate(5);

        return view('user.channel', [
            'user' => $user,
            'videos' => $videos
        ]);
    }
}
