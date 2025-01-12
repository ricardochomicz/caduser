<div class="card mt-5" style="width: 40rem;margin:0 auto">
    <div class="card-body">
        <h3 class="card-title mt-2 mb-2">Novo Usuário</h3>
        <x-input type="text" name="name" label="Nome" value="{{ old('name') ?? @$data->name }}" />
        <x-input type="email" name="email" label="E-mail" value="{{ old('email') ?? @$data->email }}" />
        @if (request()->routeIs('users.create'))
            <x-input type="password" name="password" label="Senha" />
            <small class="text-gray-500">Caso deixe em branco a senha o usuário irá receber um e-mail de boas-vindas com
                a senha
                gerada
                automaticamente.</small>
        @endif

    </div>
    <div class="card-footer">
        <button type="submit" class="btn btn-primary">Salvar</button>
        <a href="{{ route('users.index') }}" class="btn btn-secondary">Voltar</a>
    </div>
</div>
