@extends('adminlte::page')

@section('title', 'Meus usuários')
    
@section('content_header')
    <h1>Novo usuário</h1>
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
        <form class="form-horizontal" method="POST" action="{{route('users.store')}}">
            @csrf
            
            <div class="form-group row">
                <label class="col-form-label col-sm-2">Nome completo</label>
                <div class="col-sm-10">
                    <input type="text" name="name"class="form-control @error('name') is-invalid @enderror">
                </div>
            </div>
            <div class="form-group row"> 
                <label class="col-form-label col-sm-2">Endereço de email</label>
                <div class="col-sm-10">
                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-form-label col-sm-2">Senha</label>
                <div class="col-sm-10">
                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Confirme a senha</label>
                <div class="col-sm-10">
                    <input type="password" name="password_confirmation" class="form-control">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label"></label>
                <div class="col-sm-10">
                     <input type="submit" value="Registrar" class="btn btn-success">
                </div>
            </div>
    
        </form>
    </div>
</div>
@endsection