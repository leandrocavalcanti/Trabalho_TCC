<?php
session_start();
if (empty($_SESSION)) {
    header("Location: index.php");
}


?>
<!DOCTYPE html>
<html lang="en" data-bs-theme="ligth">

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
    <script src="script.js"></script>
    <title>Organiza Fut</title>

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
                            <div class="navbar-nav">
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
    <div class="container text-center">
        <div class="row">
            <div class="col-6 col-sm-6">
                <div class="row">
                    <div class="col-12 text-center">
                        <label class="nomeTimeA" for="valorInteiroA"><b>Time A</b></label>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <input class="caixaPlac1" type="number" id="valorInteiroA" name="valorInteiroA" min="0" max="10" step="1" value="0">
                    </div>
                </div>
                <div class="btnPlacar">
                    <div class="row">
                        <br>
                        <div class="col-6">
                            <button onclick="decrementar()" class="btn btn-danger">- Gol</button>
                        </div>
                        <div class="col-6">
                            <button onclick="incrementar()" class="btn btn-success">+ Gol</button>
                        </div>
                    </div>
                </div>

            </div>
            <script>
                function incrementar() {
                    let campo = document.getElementById('valorInteiroA');
                    let valorAtual = parseInt(campo.value);
                    let valorMaximo = parseInt(campo.max);

                    if (valorAtual < valorMaximo) {
                        campo.value = valorAtual + 1;
                    }
                }

                function decrementar() {
                    let campo = document.getElementById('valorInteiroA');
                    let valorAtual = parseInt(campo.value);
                    let valorMinimo = parseInt(campo.min);

                    if (valorAtual > valorMinimo) {
                        campo.value = valorAtual - 1;
                    }
                }
            </script>
            <div class="col-6 col-sm-6">
                <div class="row">
                    <div class="col-12">
                        <label class="nomeTimeB" for="valorInteiroB"><b>Time B</b></label>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <input class="caixaPlac2" type="number" id="valorInteiroB" name="valorInteiroB" min="0" max="10" step="1" value="0">
                    </div>
                </div>
                <div class="btnPlacar">
                    <div class="row">
                        <div class="col-6">
                            <button onclick="decrementarB()" class="btn btn-danger">- Gol</button>
                        </div>
                        <div class="col-6">
                            <button onclick="incrementarB()" class="btn btn-success">+ Gol</button>
                        </div>
                    </div>
                </div>
            </div>
            <script>
                function incrementarB() {
                    let campo = document.getElementById('valorInteiroB');
                    let valorAtual = parseInt(campo.value);
                    let valorMaximo = parseInt(campo.max);

                    if (valorAtual < valorMaximo) {
                        campo.value = valorAtual + 1;
                    }
                }

                function decrementarB() {
                    let campo = document.getElementById('valorInteiroB');
                    let valorAtual = parseInt(campo.value);
                    let valorMinimo = parseInt(campo.min);

                    if (valorAtual > valorMinimo) {
                        campo.value = valorAtual - 1;
                    }
                }
            </script>
        </div>
    </div>
    <hr>
    <div class="container-secundario">
        <div class="row">
            <div class="col-12">
                <div id="cronometro">
                    <h2 id="timer">
                        00:00
                    </h2>
                    <label for="tempo"><strong> Digite o tempo:</strong></label>
                    <input type="number" id="tempo" min="1" required>
                    <div id="actions">
                        <button id="start" action="start">
                            <i class="fa fa-play" aria-hidden="true"></i>
                        </button>
                        <button id="stop">
                            <i class="fa fa-stop" aria-hidden="true"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12 text-center">
            <div class="Containerbtn text-center">

                <a href="iniciarPartida.php" class="btn btn-primary w-30 ">Novo Jogo</a>

                <a href="dashboard.php" class="btn btn-secondary ">Encerrar</a>

            </div>
        </div>
    </div>



    <script type="text/javascript" src="js/bootstrap.bundle.min.js"></script>

</body>

</html>