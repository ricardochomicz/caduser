@extends('app')

@section('content')
    <div class="content-wrapper">
        <div class="wrapper">
            <div class="image-login">
                <img src="{{ asset('assets/images/login.jpeg') }}" alt="Imagem">
            </div>
            <div class="form-login">
                @php
                    $isRegisterForm = $errors->has('name') || $errors->has('email') || $errors->has('password');
                @endphp
                <div id="loginForm" style="{{ $isRegisterForm ? 'display: none;' : '' }}">
                    <h2>Informe suas credenciais</h2>
                    <form action="{{ route('login') }}" method="post">
                        @csrf
                        <x-input label="E-mail" type="email" name="lemail" />
                        <x-input label="Senha" type="password" name="lpassword" />
                        <button type="submit" class="btn btn-primary">Entrar</button>
                    </form>
                    <a href="javascript:void(0);" onclick="showRegisterForm()" class="bottom-link">Não possuo cadastro.
                    </a>
                </div>
                <div id="registerForm" style="{{ $isRegisterForm ? '' : 'display: none;' }}">
                    <h2>Cadastre-se</h2>
                    <form action="{{ route('register') }}" method="post">
                        @csrf
                        <x-input label="Nome" type="text" name="name" value="{{ old('name') }}" />
                        <x-input label="E-mail" type="email" name="email" value="{{ old('email') }}" />
                        <x-input label="Senha" type="password" id="password" name="password"
                            value="{{ old('password') }}" />
                        <x-input label="Confirmar Senha" type="password" id="confirmPassword"
                            name="password_confirmation" />
                        <small id="passwordError" class="text-danger" style="display: none;">As senhas não
                            coincidem.</small>
                        <button type="submit" id="submitButton" disabled class="btn btn-primary">Registrar</button>
                    </form>
                    <a href="javascript:void(0)" onclick="showLoginForm()" class="bottom-link">Já sou
                        cadastrado.</a>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        function showRegisterForm() {
            const loginForm = document.getElementById('loginForm');
            const registerForm = document.getElementById('registerForm');
            if (loginForm && registerForm) {
                loginForm.style.display = 'none';
                registerForm.style.display = 'block';
            }
        }

        function showLoginForm() {
            const loginForm = document.getElementById('loginForm');
            const registerForm = document.getElementById('registerForm');
            if (loginForm && registerForm) {
                loginForm.style.display = 'block';
                registerForm.style.display = 'none';
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            const passwordInput = document.getElementById('password');
            const confirmPasswordInput = document.getElementById('confirmPassword');
            const passwordError = document.getElementById('passwordError');
            const submitButton = document.getElementById('submitButton');

            function validatePasswords() {
                if (confirmPasswordInput.value === '') {
                    // Se o campo de confirmação estiver vazio
                    confirmPasswordInput.classList.remove('is-invalid');
                    passwordError.style.display = 'none';
                    submitButton.disabled = true;
                } else if (passwordInput.value !== confirmPasswordInput.value) {
                    // Se as senhas não coincidem
                    confirmPasswordInput.classList.add('is-invalid');
                    passwordError.style.display = 'block';
                    submitButton.disabled = true;
                } else {
                    // Se as senhas coincidem
                    confirmPasswordInput.classList.remove('is-invalid');
                    passwordError.style.display = 'none';
                    submitButton.disabled = false;
                }
            }

            // Adiciona eventos de entrada para validação em tempo real
            passwordInput.addEventListener('input', validatePasswords);
            confirmPasswordInput.addEventListener('input', validatePasswords);
        });
    </script>
@endpush
