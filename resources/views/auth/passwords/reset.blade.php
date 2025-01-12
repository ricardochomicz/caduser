@extends('app')
@section('content')
    <h1 class="mt-5 mb-5">Alterar minha senha!</h1>
    <form action="{{ route('password.update') }}" method="post">
        @csrf
        <x-input type="hidden" name="token" value="{{ $token }}" />
        <x-input type="email" name="email" placeholder="Informe seu e-mail" value="{{ old('email') }}" />
        <x-input type="password" name="password" placeholder="Informe sua nova senha" />
        <x-input type="password" name="password_confirmation" placeholder="Confirme sua senha" />
        <button type="submit" class="btn btn-primary">Alterar
            Senha</button>
    </form>
    @if (session('status'))
        <div class="status"> {{ session('status') }} </div>
    @endif
@stop
