@extends('app')

@section('content')
    <form action="{{ route('users.store') }}" method="post">
        @csrf
        @include('pages.users._partials.form')
    </form>
@endsection
