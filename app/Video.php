<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Video extends Model
{

    //Especificamos a que taba hace referencia este modelo
    protected $table = 'videos';

    //Relacion One To Many
    //relacion de uno a muchos el Modelo Comentario
    public function comentarios(){
        return $this->hasMany('App\Comentario');
    }

    // Relacion de Muchos a uno
    //Le especificamos la dependiencia de la entidad
    //Ya que un usuario puede crear muchos videos
    public function user(){
        return $this->belongsTo('App\User', 'user_id');
    }

}
