<?php
session_start();
include('config.php');



$sql = "SELECT * FROM dadosJogador";
$result = $conn->query($sql);


?>
<!DOCTYPE html>
<html lang="PT-BR" data-bs-theme="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/styledashboard.css">
    <link rel="website icon" type="png" href="imagens/PELADA.PNG" C:\xampp\htdocs\TrabalhoTCC>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Sedgwick+Ave+Display&display=swap" rel="stylesheet">

    <title>Organiza Fut</title>
    <style>
        .btn {
            position: relative;
            top: 300%;
        }
    </style>
</head>

<body>
    <div class="containerMenu text-center d-lg-block">
        <div class="row">
            <div class="col-12">
                <nav class="navbar navbar-expand-lg bg-body-tertiary" data-bs-theme="dark">
                    <div class="container-fluid">
                        <a class="navbar-brand" href="dashboard.php">
                            Organiza Fut
                        </a>
                        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                            <div class="navbar-nav text-end">
                                <a class="nav-link" href="logout.php">Sair</a>
                            </div>
                        </div>
                    </div>
                </nav>
            </div>
        </div>
    </div>
    <nav class="navbar bg-body-tertiary fixed-top d-lg-none" data-bs-theme="dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="dashboard.php">Organiza Fut</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
                <div class="offcanvas-header">
                    <h5 class="navbar-brand" id="offcanvasNavbarLabel">Organiza Fut</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>
                <div class="offcanvas-body">
                    <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">

                        <a href="logout.php" type="button" class="btn btn-outline-danger">Sair</a>
                    </ul>
                </div>
            </div>
        </div>
    </nav>

    <div class="containerBoasVindas">
        <div class="row">
            <div class="col-12 text-center">
                <div class="boas-vindas">
                    <?php
                    print "Olá "  . $_SESSION["nomeJogador"] . ", Seja Bem-Vindo!";
                    ?>
                </div>
            </div>
        </div>
    </div>
    <div class="containerBodyDash">
        <div class="row">
            <div class="col-sm-4 mb-3 mb-sm-0 text-center">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Meus Jogos</h5>
                        <a href="seusGrupos.php" class="btn btn-primary w-100">Entrar</a>
                    </div>
                </div>
            </div>
            <div class="col-sm-4 mb-3 mb-sm-0 text-center">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Criar Jogos</h5>
                        <a href="criargrupo.php" class="btn btn-primary w-100">Entrar</a>
                    </div>
                </div>
            </div>
            <div class="col-sm-4 mb-3 mb-sm-0 text-center">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Cronometro</h5>
                        <a href="iniciarPartida.php" class="btn btn-primary w-100">Entrar</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript" src="js/bootstrap.bundle.min.js"></script>
</body>

</html>