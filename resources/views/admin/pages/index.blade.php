@extends('adminlte::page')

@section('title', 'Meus usuários')
    
@section('content_header')
    <h1>Páginas</h1>
    <a href="{{ route('pages.create') }}" class="btn btn-sm btn-success">Criar nova página</a>
@endsection

@section('content')
@if (session('success'))
    <div class="alert alert-info">
        {{ session('success') }}
    </div>
@endif
@if (session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif
    <table class="table table-hover">
        <tr>
            <th>ID</th>
            <th>Título</th>
            <th>Ações</th>
        </tr>
        @foreach ($pages as $page)
            <tr>
                <td>{{$page->id}}</td>
                <td>{{$page->title}}</td>
                <td>
                    <a href="{{ url('/'. $page->slug) }}" class="btn btn-success" target="_blank">Ver</a>
                    <a href="{{ route ('pages.edit', ['page' => $page->id]) }}" class="btn btn-info">Editar</a>
                    <form class="d-inline" method="POST" action="{{ route ('pages.destroy', ['page' => $page->id]) }}" onsubmit="return confirm('Tem certeza que deseja excluir o usuário?')">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger">Excluir</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </table>
    {{$pages->links()}}
@endsection
