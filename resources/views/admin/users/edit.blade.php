@extends('adminlte::page')

@section('title', 'Meus usuários')
    
@section('content_header')
    <h1>Editar usuário</h1>
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
        <form class="form-horizontal" method="POST" action="{{route('users.update', ['user' => $user->id])}}">
            @csrf
            @method('PUT')
            <div class="form-group row">
                <label class="col-form-label col-sm-2">Nome completo</label>
                <div class="col-sm-10">
                    <input type="text" name="name" value="{{$user->name}}" class="form-control @error('name') is-invalid @enderror">
                </div>
            </div>
            <div class="form-group row"> 
                <label class="col-form-label col-sm-2">Endereço de email</label>
                <div class="col-sm-10">
                    <input type="email" name="email"  value="{{$user->email}}" class="form-control @error('email') is-invalid @enderror">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-form-label col-sm-2">Nova senha</label>
                <div class="col-sm-10">
                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Confirme a nova senha</label>
                <div class="col-sm-10">
                    <input type="password" name="password_confirmation" class="form-control">
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