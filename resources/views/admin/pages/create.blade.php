@extends('adminlte::page')

@section('title', 'Meus usuários')
    
@section('content_header')
    <h1>Nova página</h1>
@endsection

@section('content')
@if ($errors->any())
    <div class="alert alert-danger alert-dismissible">
       <ul>
           <h5><i class="icon fas fa-ban"></i>Ocorreu um erro!</h5>
            @foreach ($errors->all() as $error)
                <li>{{$error}}</li>
            @endforeach
       </ul>
    </div>  
@endif
<div class="card">
    <div class="card-body">
        <form class="form-horizontal" method="POST" action="{{route('pages.store')}}">
            @csrf
            
            <div class="form-group row">
                <label class="col-form-label col-sm-2">Título da página</label>
                <div class="col-sm-10">
                    <input type="text" name="title" class="form-control @error('name') is-invalid @enderror">
                </div>
            </div>
            <div class="form-group row"> 
                <label class="col-form-label col-sm-2">Conteúdo</label>
                <div class="col-sm-10">
                    <textarea name="body" id="textarea" class="form-control"></textarea>
                </div>
            </div>
            
            <div class="form-group row">
                <label class="col-sm-2 col-form-label"></label>
                <div class="col-sm-10">
                     <input type="submit" value="Adicionar página" class="btn btn-success">
                </div>
            </div>
    
        </form>
    </div>
</div>
<script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
<script>
    tinymce.init({
      selector: '#textarea',
      height:300,
      menubar:false,
      plugins:['link', 'table', 'image', 'autoresize', 'lists'],
      toolbar: 'link image|formatselect| bold italic|alignleft aligncenter alignright alignjustify|table',
      content_css: [
          '{{asset('assets/css/content.css')}}'
      ],
      images_upload_url: '{{route('imageupload')}}',
      images_credentials:true,
      convert_urls:false
    });
  </script>
@endsection