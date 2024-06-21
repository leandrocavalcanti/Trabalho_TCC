<?php
session_start();
include('config.php');


if (isset($_SESSION['emailJogador'])) {
    // Obtém o id do jogador da sessão
    $emailJogador = $_SESSION['emailJogador'];

    $stmt = $conn->prepare("SELECT idJogador FROM jogador WHERE emailJogador = ?");
    $stmt->bind_param("s", $emailJogador);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $idJogador = $row['idJogador'];
    }
}
$sql = "SELECT * FROM grupo";

$result = $conn->query($sql) or die($conn->error);

$qtd = $result->num_rows;

?>
<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">

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
                <nav class="navbar navbar-expand-lg bg-body-tertiary">
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
    <nav class="navbar bg-body-tertiary fixed-top d-lg-none">
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

    <div class="container">
        <div class="row">
            <div class="col-12 text-center">
                <h5 class='nGrup'>Todos Grupos</h5>
            </div>
        </div>
    </div>

    <?php


    if ($qtd > 0) {
        echo "<div class='row'>";
        echo "<div class='col-12 text-center'>";
        echo "<div class='qntResult'><p>Exitem<b> $qtd</b> Grupo(s)</p></div>";
        echo "</div>";
        echo "</div>";
        echo "<div class='row'>";
        echo "<div class='col-12'>";
        echo "<form class='pesqGrupo' action='pesquisarGrupos.php' method='POST'>";
        echo "<input type='text' name='nomeGrupo' placeholder='Digite o nome do grupo'>";
        echo "<button type='submit' class='btn btn-primary'>Pesquisar</button>";
        echo "</form>";
        echo "</div>";
        echo "</div>";
        while ($row = $result->fetch_object()) {
            echo "<div class='containerGrupo text-center'>";
            echo "<div class='row'>";
            echo "<div class='col-12 text-center'>";
            echo "<div class='card'>";
            echo "<div class='card-body'>";
            echo "<h5 class='card-title text-center'>" . $row->nomeGrupo . "</h5>";
            echo "<p class='card-desc text-center'>" . $row->descricaoGrupo . "</p>";
            echo "<p class='card-desc text-center'>" . $row->diaSemana . "</p>";
            echo "<p class='card-desc text-center'>" . $row->horaJogo . "</p>";
            echo"<div class='btnVer'>";
            echo "<button onclick=\"location.href='verGrupo.php?idGrupo=$row->idGrupo';\"class='btn btn-warning'>Ver Grupo</button>";
            echo"</div>";
            echo "<button onclick=\"location.href='entrarGrupo.php?idGrupo=$row->idGrupo';\" class='btn btn-success'>Entrar</button>";
            echo"</div>";
            echo "</div>";
            echo "</div>";
            echo "</div>";
            echo "</div>";
            echo "</div>";
        }
    } else {
        print "<p>Não encontrou resultado</p>";
    }
    ?>
    <div class="btnGrup text-center">
        <div class="row">
            <div class="col-12">
                <a href="dashboard.php" class="btn btn-primary"> Voltar </a>
            </div>
        </div>
    </div>

    <script type="text/javascript" src="js/bootstrap.bundle.min.js"></script>
</body>

</html>