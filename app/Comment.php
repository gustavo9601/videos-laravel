<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{

    //Especificamos a que taba hace referencia este modelo
    protected $table = 'comments';

    public function video(){
        return $this->belongsTo(Video::class, 'video_id');
    }

    // Relacion de Muchos a uno
    //Le especificamos la dependiencia de la entidad
    //Ya que un usuario puede crear muchos comentarios
    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }

}
