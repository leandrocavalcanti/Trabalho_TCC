<!DOCTYPE html>
<html lang="en" data-bs-theme="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="website icon" type="png" href="imagens/PELADA.PNG" C:\xampp\htdocs\TrabalhoTCC>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Sedgwick+Ave+Display&display=swap" rel="stylesheet">

    <title>Organiza Fut</title>
</head>

<body class="d-flex align-items-center py-4 bg-body-tertiary">
    <main class="w-100 m-auto form-container">

        <h1>ORGANIZA FUT</h1>
        <h2 class="loginpalavra">Login</h2>
        <div class="caixa">
            <div class="form-group">
                <form action="login.php" method="POST">
                    <label for="emailJogador">E-mail: </label>
                    <input type="email" name="emailJogador" class="form-control" placeholder="Seu email" required>
            </div>
            <div class="form-group">
                <label for="senhaJogador">Senha: </label>
                <input type="password" name="senhaJogador" class="form-control" placeholder="Senha" required>
            </div><br><br>
            <button type="submit" class="btn btn-primary w-100 py-2">Entrar</button>
        </form>
        <form action="cadastroJogador.php" method="POST">
            <div><br>
                <button type="submit" class="btn btn-success w-100 py-2">Cadastrar</button>
            </div>
        </form>
        </div>

    </main>
    <script type="text/javascript" src="js/bootstrap.bundle.min.js"></script>
</body>

</html>