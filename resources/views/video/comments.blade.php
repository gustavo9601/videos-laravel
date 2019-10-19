<hr>
<h4>Comentarios</h4>
<hr>

@if(session('message'))

    <div class="alert alert-success">
        {{session('message')}}
    </div>

@endif



<div class="row">

        @foreach($comments as $comment)
            <div class="card col-3 m-1">
                <div class="card-body">
                    <h5 class="card-title">Fecha: {{$comment->created_at}}</h5>
                    <h6 class="card-subtitle mb-2 text-muted">Usuario: {{$comment->user_id}}</h6>
                    <p class="card-text">{{$comment->body}}</p>
                    {{--<a href="#" class="card-link">Editar</a>--}}



                    <!-- Botón en HTML (lanza el modal en Bootstrap) -->
                    <a href="#eliminarComentario-{{$comment->id}}" role="button" class="card-link" style="color: red;" data-toggle="modal">Eliminar</a>

                    <!-- Modal / Ventana / Overlay en HTML -->
                    <div id="eliminarComentario-{{$comment->id}}" class="modal fade">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title">¿Estás seguro?</h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                </div>
                                <div class="modal-body">
                                    <p>¿Seguro que quieres borrar este comentario?</p>
                                    <p class="text-danger"><small>{{$comment->body}}</small></p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                                    <a href="{{url('delete-comment')}}/{{$comment->id}}" class="btn btn-danger">De una !!!!</a>
                                </div>
                            </div>
                        </div>
                    </div>




                </div>
            </div>
        @endforeach

</div>


<ul>




    {{--    {{dd($comments)}}--}}


</ul>


{{--Verificamos que se halla autenticado el usuario para mostrar los comentarios--}}
@if(Auth::check())
    <form action="{{url('/save-comentario')}}" class="col-6" method="post">

        {!! csrf_field() !!}


        <input type="hidden" name="video_id" class="form-control" value="{{$video->id}}" required>

        <p>
            <textarea name="body" id="" class="form-control" required></textarea>
        </p>


        <input type="submit" class="btn btn-outline-info" value="Enviar comentario">
    </form>
@endif