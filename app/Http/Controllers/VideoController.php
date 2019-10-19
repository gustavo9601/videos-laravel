<?php

namespace App\Http\Controllers;

use App\Comment;
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
            $file_path = time() . $file->getClientOriginalName();

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


    public function getVideoDetail($video_id)
    {

        //findOrFail($id) busca por id en el tabla modelo, si no encuentra retorna un error
        $video = Video::findOrFail($video_id);

        $comments = DB::table('comments')->where('video_id', $video_id)->get();


        // die(dd(($comments)));

        return view('video.video-detail', [
            'video' => $video, // le enviamos esta variable a la vista
            'comments' => $comments
        ]);

    }


    public function deleteVideo($video_id)
    {
        $user = \Auth::user();  //capturando al usuario identificado
        $video = Video::find($video_id);  // capturando el video


        //die(dd($video));

        $comments = Comment::where('video_id', $video_id);

        //Validacion si existe la autenticacion
        //y si el usuario autenticado es quien publico el video
        if ($user && $video->user_id == $user->id) {

            //Eliminar comentarios
            $comments->delete();   //elimina los comentarios del vido

            //Eliminar los ficheros
            \Storage::disk('images')->delete($video->image);  //eliminamos la imaen
            \Storage::disk('videos')->delete($video->video_path);  //eliminamos el video

            //Eliminar registro de la BD
            $video->delete();

            return redirect()->route('home')->with(['message' => 'Video eliminado correctamente']);

        }


        return redirect()->route('home');
    }



    public function vistaEditVideo($video_id)
    {
        $user = \Auth::user();
        $video = Video::findOrFail($video_id);


        if($user && $user->id == $video->user_id){

            return view('video.edit', [
                'video' => $video
            ]);
        }else{

            return redirect()->route('home');
        }
    }


    public function updateVideo($video_id, Request $request){

        $rules = [
            'title' => 'required|min:5',
            'description' => 'required',
            'video' => 'mimes:mp4',  //formato especifico
        ];

        //Validamos los campos pasados
        $validate = $this->validate($request, $rules);


        //Capturamos el video pasado por parametro ger
        $user = \Auth::user();
        $video = Video::findOrFail($video_id);

        //Seteando los parametros del video
        $video->user_id = $user->id;
        $video->title = $request->input('title');
        $video->description = $request->input('description');

        //subiendo el archivo
        //usamos en ves de input file, ya que es un archivo solo si se envia, en caso contraria se dejara tal y como esta el objeto que viene de la BD
        if($request->file('image')){
            $video->image = $this->uploadFile($request->file('image'), 'image');
        }
        if($request->file('video')){
            $video->video_path = $this->uploadFile($request->file('video'), 'video');
        }


        $video->save(); //guardara en la BD la informacion proporcionada en los parametros

        return redirect()->route('video-detail', $video->id)->with(['message' => 'EL video se actualizo correctamente']);



    }

}
