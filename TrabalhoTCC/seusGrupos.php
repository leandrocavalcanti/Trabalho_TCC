<?php
session_start();
if (empty($_SESSION)) {
    header("Location: index.php");
    exit();
}
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
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />

    <title>Organiza Fut</title>
    <style>
        .btn {
            align-items: center;
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
    <div class="row">
        <div class="col-12 text-center">
            <p class="nGrup">Meus Jogos</p>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <?php
            include('config.php');

            if (isset($_SESSION['emailJogador'])) {
                $emailJogador = $_SESSION['emailJogador'];
                $stmt = $conn->prepare("SELECT idJogador FROM jogador WHERE emailJogador = ?");
                $stmt->bind_param("s", $emailJogador);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    $idJogador = $row['idJogador'];

                    // Consulta SQL para obter os grupos em que o jogador está associado
                    $sql = "SELECT g.idGrupo, g.nomeGrupo, g.diaSemana, g.horaJogo, g.idCriador
                            FROM grupo_has_jogador gj 
                            JOIN grupo g ON gj.grupo_idGrupo = g.idGrupo
                            WHERE gj.jogador_idJogador = ?";

                    $stmt = $conn->prepare($sql);
                    if ($stmt) {
                        $stmt->bind_param("i", $idJogador);
                        if ($stmt->execute()) {
                            $resultGrupos = $stmt->get_result();

                            if ($resultGrupos->num_rows > 0) {
                                while ($rowGrupo = $resultGrupos->fetch_assoc()) {
                                    echo "<div class='col-lg-4 col-md-6 col-sm-12 mb-4'>";
                                    echo "<div class='card'>";
                                    echo "<div class='card-body'>";
                                    echo "<h5 class='card-title text-center'>" . htmlspecialchars($rowGrupo['nomeGrupo']) . "</h5>";
                                    echo "<p class='card-text'>" . htmlspecialchars($rowGrupo['diaSemana']) . "</p>";
                                    echo "<p class='card-text'>" . htmlspecialchars($rowGrupo['horaJogo']) . "</p>";
                                    echo "<div class='btnCardGrupo d-flex justify-content-between'>";
                                    echo "<a href='paginaGrupo.php?idGrupo=" . $rowGrupo['idGrupo'] . "' class='btn btn-primary'>Entrar</a>";
                                    echo "<form action='sairGrupo.php' method='post'>";
                                    echo "<input type='hidden' name='idGrupo' value='" . $rowGrupo['idGrupo'] . "'>";
                                    echo "<button type='submit' name='sairGrupo' class='btn btn-danger'>Sair</button>";
                                    echo "</form>";
                                    if ($idJogador == $rowGrupo['idCriador']) {
                                        echo "<a href='editarGrupo.php?acao=editarGrupo&idGrupo=" . $rowGrupo['idGrupo'] . "' class='btn btn-secondary'><span class='material-symbols-outlined'>edit</span></a>";
                                        echo "<a href='salvargrupo.php?acao=excluirGrupo&idGrupo=" . $rowGrupo['idGrupo'] . "' class='btn btn-danger'><span class='material-symbols-outlined'>delete</span></a>";
                                    }
                                    echo "</div>"; // Fechamento div .btnCardGrupo
                                    echo "</div>"; // Fechamento div .card-body
                                    echo "</div>"; // Fechamento div .card
                                    echo "</div>"; // Fechamento div .col
                                }
                            } else {
                                echo "<div class='col-12 text-center mt-4'>";
                                echo "<p>Você ainda não entrou em nenhum grupo.</p>";
                                echo "</div>";
                            }
                        } else {
                            echo "Erro ao executar a consulta: " . $conn->error;
                        }
                        $stmt->close();
                    } else {
                        echo "Erro na preparação da consulta: " . $conn->error;
                    }
                } else {
                    echo "Usuário não encontrado.";
                }
            } else {
                echo "Usuário não está logado.";
            }

            $conn->close();
            ?>
            <div class="btnVoltSeusGrupos text-center mt-4">
        <div class="row">
            <div class="col-12 col-sm-12">
                <a class="btn btn-primary" href="dashboard.php" role="button">Voltar</a>
            </div>
        </div>
    </div>
        </div> <!-- Fechamento div .row -->
    </div> <!-- Fechamento div .container -->

    

    <script type="text/javascript" src="js/bootstrap.bundle.min.js"></script>
</body>

</html>
