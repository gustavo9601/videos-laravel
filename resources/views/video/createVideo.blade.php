{{--Herando la plantilla padre--}}
@extends('layouts.app')


{{--Introduccimos dentro de la plantilla en el bloque contet --}}
@section('content')

    <div class="container">

        <div class="row">
            <div class="col-12">
                <h3>Crear un nuevo video</h3>
                <hr>

                {{--

                route('saveVideo')   // pasandole el nombre
                url('/save-video')   //pasandole la ruta

                --}}
                <form action="{{url('/save-video')}}" method="post" enctype="multipart/form-data" class="col-7">

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
                        <input type="text" class="form-control" name="title" id="title" value="{{old('title')}}">
                    </div>
                    <div class="form-group">
                        <label for="description">Descripcion</label>
                        <textarea name="description" id="description" class="form-control">
                            {{old('description')}}
                        </textarea>
                    </div>
                    <div class="form-group">
                        <label for="image">Imagen</label>
                        <input type="file" class="form-control" name="image" id="image" value="{{old('image')}}">
                    </div>
                    <div class="form-group">
                        <label for="video">Video</label>
                        <input type="file" class="form-control" name="video" id="video" value="{{old('video')}}">
                    </div>

                    <button type="submit" class="btn btn-outline-info">Guardar</button>


                </form>

            </div>
        </div>


    </div>
@endsection

