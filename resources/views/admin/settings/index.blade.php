@extends('adminlte::page')

@section('title', 'Configuraçoes do site')

@section('content_header')
    <h1>Configuraçoes</h1>
@endsection

@section('content')
@if ($errors->any())
    <div class="alert alert-danger alert-dismissible">
        @foreach ($errors->all() as $error)
            <table>
                <th>{{$error}}</th>
            </table>
        @endforeach
    </div>  
@endif
    <div class="card">
        <div class="card-body">
            <form action="{{route('settings.save')}}" method="POST" class="form-horizontal">
                @method('PUT')
                @csrf
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Título do site</label>
                    <div class="col-sm-10">
                        <input type="text" name="title" value="{{(empty($settings) ? '': $settings['title'])}}" class="form-control">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Subtitulo do site</label>
                    <div class="col-sm-10">
                        <input type="text" name="subtitle" class="form-control" value="{{(empty($settings) ? '': $settings['subtitle'])}}">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Contato</label>
                    <div class="col-sm-10">
                        <input type="text" name="contact" value="{{(empty($settings) ? '': $settings['contact'])}}" class="form-control">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Twitter</label>
                    <div class="col-sm-10">
                        <input type="text" name="twitter" value="{{(empty($settings) ? '': $settings['twitter'])}}" class="form-control">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Facebook</label>
                    <div class="col-sm-10">
                        <input type="text" name="facebook" value="{{(empty($settings) ? '': $settings['facebook'])}}" class="form-control">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Instagram</label>
                    <div class="col-sm-10">
                        <input type="text" name="instagram" value="{{(empty($settings) ? '': $settings['instagram'])}}" class="form-control">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label"></label>
                    <div class="col-sm-10">
                         <input type="submit" value="Salvar" class="btn btn-success">
                    </div>
                </div>
                
            </form>
        </div>
    </div>
@endsection