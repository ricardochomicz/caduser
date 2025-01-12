@extends('app')
@section('content')
    <a href="{{ route('users.create') }}" class="btn btn-secondary mt-4 ">Cadastrar Novo Usuário</a>

    <div class="table-responsive">

        <div class="search-container mt-3">
            <form action="{{ route('users.index') }}" method="get" class="form-search">
                <input type="search" name="search" id="searchInput" class="input-search"
                    placeholder="Digite sua pesquisa..." />
                <button type="submit" class="btn-search">Pesquisar</button>
            </form>
        </div>


        <table class="table mt-3">
            <thead>
                <tr>
                    <th class="text-center">#</th>
                    <th class="text-left">Nome</th>
                    <th class="text-left">E-mail</th>
                    <th class="text-center">Atualizado em</th>
                    <th class="text-center">...</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr>
                        <td class="text-center align-middle">{{ $user->id }}</td>
                        <td class="text-left align-middle">{{ $user->name }}</td>
                        <td class="text-left align-middle">{{ $user->email }}</td>
                        <td class="text-center align-middle">
                            {{ Carbon\Carbon::parse($user->updated_at)->format('d/m/Y H:i') }}
                        </td>
                        <td class="text-center align-middle button-container">
                            <a href="{{ route('users.edit', $user->id) }}" class="btn btn-primary">Editar</a>
                            <a href="javascript:void(0)"
                                onclick="modalDelete('{{ route('users.destroy', $user->id) }}', 'Deletar', '{{ $user->name }}')"
                                class="btn btn-danger">Deletar</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {!! $users->links() !!}
    </div>
    <x-modal title="Deletar Usuário" />
@endsection
