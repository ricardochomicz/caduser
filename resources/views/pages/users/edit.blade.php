@extends('app')

@section('content')
    <form action="{{ route('users.update', $data->id) }}" method="post">
        @csrf
        @method('PUT')
        @include('pages.users._partials.form')
    </form>
@endsection
