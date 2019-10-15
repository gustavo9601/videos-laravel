@extends('layouts.app')


@section('content')

    <div class="col-12 text-center">
        <h2>{{$video->title}}</h2>
    </div>

    <div class="col-10 offset-1">
        {{--Video--}}
        {{--Verificamos si existen en el disco videos, el video que le pasamos a buscar--}}

        <div class="row">

            <div class="col-8">
                @if(Storage::disk('videos')->has($video->video_path))

                    <video controls id="video-player" width="100%">
                        <source src="{{url('/obtener-archivo/' . $video->video_path. '/videos')}}">
                    </video>
                @endif

            </div>
            <div class="col-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">
                            Detalle:
                        </h5>
                    </div>
                    <div class="card-body">
                        <p><strong>Subido por: </strong>User_default</p>
                        <p><strong>Descripcion: </strong>{{$video->description}}</p>

                        {{--

                        usamos el helper creado, y llamaos a la funcion
                        \FormatTime::LongTimeFilter($fecha)
                        --}}
                        <p><strong>Subido el:</strong> {{  \FormatTime::LongTimeFilter($video->created_at)}}</p>
                    </div>
                </div>
            </div>
        </div>
        {{--Descripcion--}}

        {{--comentarios--}}
    </div>


@endsection