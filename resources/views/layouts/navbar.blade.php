@auth
    <nav class="navbar">
        <div class="navbar-left"> <span>Cadastro de Usuários</span> <br><small>Seja bem-vindo,
                {{ auth()->user()->name }}</small></div>
        <div class="navbar-right">
            <form action="{{ route('logout') }}" method="POST"> @csrf <button type="submit"
                    class="btn btn-logout">Sair</button> </form>
        </div>
    </nav>
@endauth


@push('scripts')
    <script>
        function logout() {
            // Adicione a lógica de logout aqui 
            alert('Você saiu do sistema.');
        }
    </script>
@endpush
