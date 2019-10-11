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

        //subiendo el archivo
        //usamos en ves de input file, ya que es un archivo
        $video->image = $this->uploadFile($request->file('image'), 'image');
        $video->video_path = $this->uploadFile($request->file('video'), 'video');

        $video->save(); //guardara en la BD la informacion proporcionada en los parametros

        return redirect()->route('home')->with(['message' => 'EL video se creo correctamente']);
    }


    private function uploadFile($file, $type)
    {

        $disk = ($type === 'image') ? 'images' : 'videos';

        if ($file) {
            //Capturando el path y nombre del archivo
            $file_path = $file->getClientOriginalName();

            /*
             * \Storage::disk('images')   //usamos la funcion que seleccionara la ubicacion del disco creado en config/filesustems.php
             * en este caso le especificamos que suba al directorio storage/images
             * ->put($file_path, \File::get($file))  le pasamos el path de la imagen, y el archivo como tal
             * */

            \Storage::disk($disk)->put($file_path, \File::get($file));

            return $file_path;

        } else {
            return null;
        }

    }


    public function getFile($filename, $type)
    {

        //type contendra si el disco es images o videos
        $file = Storage::disk($type)->get($filename);

        //Retornara la url de la imagen
        // con un estado 200

        /*De esta forma protegemos las imagenes ya que las retorna encodeadas*/

        return new Response($file, 200);
    }

}
