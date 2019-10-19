{{--Herando la plantilla padre--}}
@extends('layouts.app')


{{--Introduccimos dentro de la plantilla en el bloque contet --}}
@section('content')

    <div class="container">

        <div class="row">
            <div class="col-12">
                <h3>Editar el video</h3>
                <hr>

                {{--

                route('saveVideo')   // pasandole el nombre
                url('/save-video')   //pasandole la ruta

                --}}
                <form action="{{url('/update-video')}}/{{$video->id}}" method="post" enctype="multipart/form-data" class="col-7">

                    {{--
                    csrf_field ()  //genera el token para el formulario
                     --}}
                    {!! csrf_field() !!}


                    {{--Si existe algun dato incorrecto, por no pasar la validacion--}}
                    {{--la variable errors es global y retorna todos los errores--}}
                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                {{--$errors->all()  retorna un arreglo de errores--}}
                                @foreach($errors->all() as $error)
                                    <li>{{$error}}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="form-group">
                        <label for="title">Titulo</label>
                        {{--
                        old('title')  //permite guardar en temporal la ultima informacion enviada
                         --}}
                        <input type="text" class="form-control" name="title" id="title" value="{{$video->title}}">
                    </div>
                    <div class="form-group">
                        <label for="description">Descripcion</label>
                        <textarea name="description" id="description" class="form-control">
                            {{$video->description}}
                        </textarea>
                    </div>
                    <div class="form-group">
                        <label for="image">Imagen</label>
                        @if(Storage::disk('images')->has($video->image))
                            <img style="width: 30%" src="{{url('/obtener-archivo/' . $video->image . '/images')}}"
                                 class="card-img-top" alt="{{$video->title}}">
                        @else
                            <img style="width: 30%" src="{{url('/obtener-archivo/default.png/images')}}"
                                 class="card-img-top" alt="default">
                        @endif

                        <input type="file" class="form-control" name="image" id="image" value="{{old('image')}}">
                    </div>
                    <div class="form-group">
                        <label for="video">Video</label>
                        @if(Storage::disk('videos')->has($video->video_path))

                            <video controls id="video-player" width="30%">
                                <source src="{{url('/obtener-archivo/' . $video->video_path. '/videos')}}">
                            </video>
                        @endif
                        <input type="file" class="form-control" name="video" id="video" value="{{old('video')}}">
                    </div>

                    <button type="submit" class="btn btn-outline-info">Guardar</button>


                </form>

            </div>
        </div>


    </div>
@endsection

