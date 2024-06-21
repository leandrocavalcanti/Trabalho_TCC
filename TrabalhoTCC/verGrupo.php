<?php
session_start();
if (empty($_SESSION)) {
    header("Location: index.php");
}

?>
<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">

<head>
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

    <div class="row">
        <div class="col-12 text-center">
            <p class="nGrup">Usuários do Grupo:</p>
        </div>
    </div>
    <?php
    include('config.php');

    if (isset($_SESSION['emailJogador'])) {
        // Obtém o id do jogador da sessão
        $emailJogador = $_SESSION['emailJogador'];
    }
    $stmt = $conn->prepare("SELECT idJogador FROM jogador WHERE emailJogador = ?");
    $stmt->bind_param("s", $emailJogador);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $idJogador = $row['idJogador'];
    }
    if (isset($_GET['idGrupo'])) {
        $idGrupo = $_GET['idGrupo'];

        // Consulta SQL para obter os usuários que pertencem ao grupo
        $sql = "SELECT j.idJogador, j.nomeJogador, j.emailJogador 
                                FROM grupo_has_jogador gj
                                JOIN jogador j ON gj.jogador_idJogador = j.idJogador
                                WHERE gj.grupo_idGrupo = ?";

        $stmt = $conn->prepare($sql);

        if ($stmt) {
            $stmt->bind_param("i", $idGrupo);
            if ($stmt->execute()) {
                $result = $stmt->get_result();
                $qtd = $result->num_rows;

                if ($result->num_rows > 0) {
                    echo "<div class='row'>";
                    echo "<div class='col-12 text-center'>";
                    echo "<p>Grupo contém <b> $qtd</b> jogadores(s)</p>";
                    echo "</div>";
                    echo "</div>";
                    while ($row = $result->fetch_assoc()) {
                        echo"<div class='row'>";
                        echo"<div class='col-12 text-center'>";
                        echo "<table class='tablemyjog table-bordered table-striped table-houver'>";
                        echo "<tr><th style='width: 200px; text-align: center'>Nome do Jogador</th>
                                    <th style='width: 200px; text-align: center'>Email do Jogador</th></tr>";
                        echo "<tr>";
                        echo "<td style='text-align: center'>" . $row['nomeJogador'] . "</td>";
                        echo "<td style='text-align: center'>" . $row['emailJogador'] . "</td>";
                        echo "</tr>";
                        echo"</div>";
                        echo"</div>";
                        echo "</table>";
                        
                    }

                    
                } else {
                    echo "Não há usuários neste grupo.";
                }
            } else {
                echo "Erro ao executar a consulta: " . $conn->error;
            }
            $stmt->close();
        } else {
            echo "Erro na preparação da consulta: " . $conn->error;
        }
    } else {
        echo "ID do grupo não especificado.";
    }
    $conn->close();
    ?>
<div class="row">
    <div class="col-12 text-center">
<a href="grupo.php" class="btn btn-primary">Voltar</a>
    </div>
</div>
   
<script type="text/javascript" src="js/bootstrap.bundle.min.js"></script>
</body>

</html>