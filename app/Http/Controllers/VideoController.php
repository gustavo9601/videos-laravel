<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

use App\Video;
use App\Comentario;

class VideoController extends Controller
{

    //Funcion que retornara el video
    public function createVideo()
    {
        return view('video.createVideo');
    }

    public function saveVideo(Request $request)
    {

        //Validar formulario
        $reglasValidacion = [
            'title' => 'required|min:5',
            'description' => 'required',
            'video' => 'mimes:mp4',  //formato especifico
        ];

        //Valida los datos
        $validateData = $this->validate($request, $reglasValidacion);


        //Creamos el objeto de video
        $video = new Video();
        $user = \Auth::user();  //capturamos el usuario que se autentico
        $video->user_id = $user->id;
        $video->title = $request->input('title');
        $video->description = $request->input('description');

        $video->save(); //guardara en la BD la informacion proporcionada en los parametros

        return redirect()->route('home')->with(['message' => 'EL video se creo correctamente']);
    }

}
