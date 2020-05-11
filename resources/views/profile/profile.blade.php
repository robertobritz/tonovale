@extends('layouts.app')

@section('title', 'Meu Perfil') 

@section('content')

<h1>Meu Perfil</h1>


@if (session('success'))
    <div class="alert alert-success">
            {{ session('success') }}
    </div>
@endif
@if (session('error'))
    <div class="alert alert-danger">
            {{ session('error') }}
    </div>
@endif 

 {{--@include('admin.includes.alerts')--}}

<form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
    {!! csrf_field() !!}
    <div class="form-group">
        <label for="name">Nome</label>
        <input type="text" value="{{ auth()->user()->name }}" name="name" placeholder="Nome" class="form-control">
    </div>
    <div class="form-group">
        <label for="email">E-mail</label>
        <input type="email" value="{{ auth()->user()->email }}" name="email" placeholder="E-mail" class="form-control">
    </div>
    <div class="form-group">
        <label for="password">Senha</label>
        <input type="password" name="password" placeholder="Senha" class="form-control">
    </div>
    <div class="form-group">
        <label for="image">Imagem:</label><br>
            @if (auth()->user()->image != null)
            <img src="{{ url('https://tonovale.s3-sa-east-1.amazonaws.com/users/'.auth()->user()->image) }}" alt="{{ auth()->user()->name }}" style="max-width: 300px;">
            @endif
        <input type="file" name="image" class="form-control">
    </div>

    <div class="form-group">
        <button type="submit" class="btn btn-info">Atualizar Perfil</button>
    </div>
</form>

@endsection