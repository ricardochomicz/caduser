@extends('app')
@section('content')
    <h1 class="mt-5 mb-5">Esqueci minha senha!</h1>
    <form action="{{ route('password.email') }}" method="post">
        @csrf
        <x-input type="email" name="email" placeholder="Informe seu e-mail" />
        <button type="submit" class="btn btn-primary">Enviar link de redefinição de senha</button>
    </form>

    @if (session('status'))
        <div class="status">
            {{ session('status') }}
        </div>
    @endif

@stop
