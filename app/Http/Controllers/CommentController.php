<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

//usamos el modelo de comentario
use App\Comment;

class CommentController extends Controller
{

    public function store(Request $request)
    {
        $validaciones = [
            'body' => 'required|min:5'
        ];

        $validate = $this->validate($request, $validaciones);

        $comment = new Comment();
        $user = \Auth::user();  //capturamos la informacion del usuario autenticado
        //seteando las variables
        $comment->user_id = $user->id;
        $comment->video_id = $request->input('video_id');
        $comment->body = $request->input('body');

        $comment->save();

        //redirigimos a la misma ruta del video, para que se actualicen los cambios
        return redirect()->route('video-detail', ['video_id' => $comment->video_id])
                        ->with([  //le enviamos una variable de session flash
                            'message' => 'Comentario añadido correctamente'
                        ]);

    }



    public function deleteComment($comment_id)
    {
        $comment = Comment::find($comment_id);

        $user = \Auth::user();  //capturando al usuario identificado

        //Validacion si existe el video y si el usuario autenticado es el que creo el comentario
        if ($comment && $comment->user_id == $user->id) {
            $comment->delete();
            return redirect()->route('video-detail', $comment->video_id)->with(['message' => 'Comentario eliminado correctamente']);
        }

        return redirect()->route('video-detail/' . $comment->video_id);

    }


}
