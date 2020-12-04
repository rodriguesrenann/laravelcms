@extends('adminlte::page')

@section('plugins.Chartjs', true)

@section('title', 'Dashboard')
    
@section('content_header')
<div class="row">
    <div class="col-md-6">
        <h1>Dashboard</h1>
    </div>
    <div class="col-md-6">
        <form method="GET" >
            <select onChange="this.form.submit()" name="interval" class="float-md-right">
                <option value="30" {{$interval == 30 ? 'selected="selected"':''}}>Últimos 30 dias</option>
                <option value="60" {{$interval == 60 ? 'selected="selected"':''}}>Últimos 60 dias</option>
                <option value="90" {{$interval == 90 ? 'selected="selected"':''}}>Últimos 90 dias</option>
                <option value="120" {{$interval == 120 ? 'selected="selected"':''}}>Últimos 120 dias</option>
            </select>
        </form>
    </div>
</div>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-3">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{$visitors}}</h3>
                    <p>Visitantes</p>
                </div>
                <div class="icon">
                    <i class="far fa-fw fa-eye"></i>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{$onlineUsers}}</h3>
                    <p>Usuários online</p>
                </div>
                <div class="icon">
                    <i class="far fa-fw fa-heart"></i>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{$pages}}</h3>
                    <p>Páginas criadas</p>
                </div>
                <div class="icon">
                    <i class="far fa-fw fa-file"></i>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3>{{$users}}</h3>
                    <p>Usuários registrados</p>
                </div>
                <div class="icon">
                    <i class="far fa-fw fa-user"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Páginas mais visitadas</h3>
                </div>
                <div class="card-body">
                    <canvas id="pagePie"></canvas>
                </div>
            </div>
        </div>
    </div>
    <script>
        window.onload = function() {
            let ctx = document.getElementById('pagePie').getContext('2d');
            window.pagePie = new Chart(ctx, {
                type:'pie',
                data:{
                    datasets:[{
                        data: {{$pageValues}},
                        backgroundColor: '#0000FF'
                    }],
                    labels: {!! $pageLabels !!}
                },
                options: {
                    responsive:true,
                    legend: {
                        display:false
                    }
                }
            });
        }
    </script>
@endsection