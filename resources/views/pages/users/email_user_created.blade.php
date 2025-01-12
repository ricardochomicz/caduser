<!DOCTYPE html>
<html>

<head>
    <title>Conta Criada</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <h1>Bem-vindo ao CadUser!</h1>
    <p>Sua conta foi criada com sucesso.</p>
    <p><strong>Email:</strong> {{ $email }}</p>
    <p><strong>Senha:</strong> {{ $password }}</p>
    <p>Por favor, altere sua senha após o primeiro login.</p>
</body>

</html>
