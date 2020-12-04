@extends('adminlte::page')

@section('title', 'Meus usuários')
    
@section('content_header')
    <h1>Meus usuários</h1>
    <a href="{{ route('users.create') }}" class="btn btn-sm btn-success">Adicionar novo usuário</a>
@endsection

@section('content')
    <table class="table table-hover">
        <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>Email</th>
            <th>Ações</th>
        </tr>
        @foreach ($users as $user)
            <tr>
                <td>{{$user->id}}</td>
                <td>{{$user->name}}</td>
                <td>{{$user->email}}</td>
                <td>
                    <a href="{{ route ('users.edit', ['user' => $user->id]) }}" class="btn btn-info">Editar</a>
                    @if($user->id != $loggedId)
                        <form class="d-inline" method="POST" action="{{ route ('users.destroy', ['user' => $user->id]) }}" onsubmit="return confirm('Tem certeza que deseja excluir o usuário?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger" >Excluir</button>
                         </form>
                    @endif
                </td>
            </tr>
        @endforeach
    </table>
    {{$users->links()}}
@endsection
