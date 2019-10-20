@extends('layouts.app')

@section('content')


    <div class="container">
        <div class="row">

            <div class="col-12">
                <h2>
                    Canal de {{$user->name}} {{$user->surname}}
                </h2>
            </div>

            {{--Validamos si se envia a la vista los videos--}}
            @if(count($videos) >= 1)

                <div class="row">


                    @foreach($videos as $video)

                        <div class="card col-md-4">

                            {{--Validacion si hay informacion la imagen existe en el storage--}}
                            {{--
                            con el has verifica que si existe o tiene ese imagen en el disco
                            --}}
                            @if(Storage::disk('images')->has($video->image))
                                <img src="{{url('/obtener-archivo/' . $video->image . '/images')}}"
                                     class="card-img-top" alt="{{$video->title}}">
                            @else
                                <img src="{{url('/obtener-archivo/default.png/images')}}"
                                     class="card-img-top" alt="default">
                            @endif
                            <div class="card-body">
                                <h4>{{$video->title}}</h4>
                                <p class="card-text">{{$video->description}}</p>
                                <p class="card-text">
                                {{-- <strong>Autor: </strong> {{$video->name}} {{$video->surname}}</p>--}}
                            </div>


                            {{--Muestra si la autenticacion es valida--}}
                            @if(Auth::check())

                                <div class="card-body">
                                    <a href="{{url('video-detail/' . $video->id)}}"
                                       class="btn btn-outline-info">Ver Video</a>
                                    {{--Comprobacion si el usuario atenticado, es el mismo que creo el video , solo el prodra modificarlo--}}
                                    @if(Auth::user()->id == $video->user_id)
                                        <a href="{{'update-video'}}/{{$video->id}}"
                                           class="btn btn-outline-dark">Editar Video</a>
                                        <a href="{{url('delete-video')}}/{{$video->id}}"
                                           class="btn btn-outline-danger">Eliminar Video</a>
                                    @endif

                                </div>
                            @endif

                        </div>

                    @endforeach
                </div>


                {{--Generando los links de paginacion--}}

                {{--
                $videos->links()  // seleccionamos la variable paginada
                // con links() automaticamente pinta la navegacion con boostrap
                --}}




                {{$videos->links()}}


            @else

                <div class="alert alert-warning">No hay video que mostrar</div>

            @endif

        </div>
    </div>

@endsection