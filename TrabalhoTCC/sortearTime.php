<?php
session_start();
if (empty($_SESSION)) {
    header("Location: index.php");
    exit();
}
include('config.php');

if (!isset($_GET['idGrupo'])) {
    // Redirecionar ou exibir uma mensagem de erro apropriada
    die('ID do grupo não definido. Certifique-se de que você selecionou um grupo.');
} else {
    $idGrupo = $_GET['idGrupo'];
    $_SESSION['idGrupo'] = $idGrupo; // Salva o ID do grupo na sessão para uso posterior
}

if (isset($_POST['numJogadores']) && !empty($_POST['numJogadores'])) {
    $numJogadores = $_POST['numJogadores'];
}


// Buscar todos os jogadores no banco de dados
$existingPlayers = [];
$result = $conn->query("SELECT nomeJogador FROM jogador WHERE idJogador IN (SELECT jogador_idJogador FROM grupo_has_jogador WHERE grupo_idGrupo = $idGrupo)");
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $existingPlayers[] = $row['nomeJogador'];
    }
}
$additionalPlayers  = [];
$result = $conn->query("SELECT nameInput FROM adicionarNome WHERE Grupo_idGrupo = $idGrupo");
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $additionalPlayers [] = $row['nameInput'];
    }
}
// Combinar jogadores selecionados e existentes
$allPlayers = array_merge($existingPlayers, $additionalPlayers );


if (!empty($allPlayers) && $numJogadores > 0) {
    shuffle($allPlayers); // Embaralha os jogadores

    $qtdJogadores = count($allPlayers);
    $numTimes = ceil($qtdJogadores / $numJogadores);
}
?>
<!DOCTYPE html>
<html lang="pt-br" data-bs-theme="light">

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
</head>

<body>
    <div class="containerMenu text-center d-lg-block" data-bs-theme="dark">
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
            <h3 class="tSort">Resultado do Sorteio:</h3>
        </div>
    </div>
    <div class="row">
        <div class="col-12 col-sm-12">
            <div class="containerBody">
                <?php
                if (isset($numTimes) && isset($numJogadores)) {
                    for ($i = 0; $i < $numTimes; $i++) {
                        echo "<div class='card'>";
                        echo "<h3>Time " . ($i + 1) . ":</h3>";
                        echo "<ul>";
                        for ($j = 0; $j < $numJogadores; $j++) {
                            if ($allPlayers) {
                                $jogador = array_pop($allPlayers);
                                echo "<li>$jogador</li>";
                            }
                        }
                        echo "</ul>";
                        echo "</div>";
                    }
                }

                ?>
            </div>
        </div>
    </div>
    <div class="btnVoltSortTime">
        <div class="row">
            <div class="col-6 text-center">
                <a href="iniciarPartida.php" class="btn btn-primary ">Iniciar Partida</a>
            </div>
            <div class="col-6 text-center">
                <a href="paginaGrupo.php?idGrupo=<?php echo $idGrupo; ?>" class="btn btn-secondary ">Voltar</a>
            </div>
        </div>
    </div>


</body>

</html>