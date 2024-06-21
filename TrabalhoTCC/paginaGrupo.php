<?php
session_start();
if (empty($_SESSION)) {
    header("Location: index.php");
    exit();
}

include('config.php');

if (isset($_SESSION['emailJogador'])) {
    $emailJogador = $_SESSION['emailJogador'];
} else {
    header("Location: index.php");
    exit();
}

// Obtém o id do jogador
$stmt = $conn->prepare("SELECT idJogador FROM jogador WHERE emailJogador = ?");
$stmt->bind_param("s", $emailJogador);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $idJogador = $row['idJogador'];
} else {
    header("Location: index.php");
    exit();
}

if (isset($_GET['idGrupo'])) {
    $idGrupo = $_GET['idGrupo'];

    // Consulta para obter o nome do grupo
    $sql_nome_grupo = "SELECT nomeGrupo FROM grupo WHERE idGrupo = ?";
    $stmt_nome_grupo = $conn->prepare($sql_nome_grupo);
    $stmt_nome_grupo->bind_param("i", $idGrupo);
    $stmt_nome_grupo->execute();
    $result_nome_grupo = $stmt_nome_grupo->get_result();

    if ($result_nome_grupo->num_rows > 0) {
        $row_nome_grupo = $result_nome_grupo->fetch_assoc();
        $nomeGrupo = $row_nome_grupo['nomeGrupo'];
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['deletePlayer'])) {
        $playerIdToDelete = $_POST['deletePlayer'];
        $deleteStmt = $conn->prepare("DELETE FROM adicionarnome WHERE idadicionarNome = ?");
        $deleteStmt->bind_param("i", $playerIdToDelete);
        $deleteStmt->execute();
        $deleteStmt->close();
    }

    // Tratamento de edição de jogador
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['editPlayer'])) {
        $playerIdToEdit = $_POST['playerId'];
        $newName = $_POST['newName'];
        $editStmt = $conn->prepare("UPDATE adicionarnome SET nameInput = ? WHERE idadicionarNome = ?");
        $editStmt->bind_param("si", $newName, $playerIdToEdit);
        $editStmt->execute();
        $editStmt->close();
    }

    // Tratamento de adição de jogador
    if (isset($_POST['nameInput']) && !empty($_POST['nameInput'])) {
        $nameInput = trim($_POST['nameInput']);
        $stmt_add_name = $conn->prepare("INSERT INTO adicionarnome (nameInput, grupo_idGrupo, jogador_idJogador) VALUES (?, ?, ?)");
        $stmt_add_name->bind_param("sii", $nameInput, $idGrupo, $idJogador);
        $stmt_add_name->execute();
        $stmt_add_name->close();
    }

    // Consulta SQL para obter os usuários que pertencem ao grupo
    $sql = "SELECT g.nomeGrupo, j.idJogador, j.nomeJogador, j.emailJogador 
            FROM grupo g
            JOIN grupo_has_jogador gj ON g.idGrupo = gj.grupo_idGrupo
            JOIN jogador j ON gj.jogador_idJogador = j.idJogador
            WHERE gj.grupo_idGrupo = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $idGrupo);
    $stmt->execute();
    $result = $stmt->get_result();
    $qtd = $result->num_rows;

    // Obtenha e exiba os jogadores adicionados
    $sql_nomes_adicionados = "SELECT idadicionarNome, nameInput FROM adicionarnome WHERE grupo_idGrupo = ?";
    $stmt_nomes_adicionados = $conn->prepare($sql_nomes_adicionados);
    $stmt_nomes_adicionados->bind_param("i", $idGrupo);
    $stmt_nomes_adicionados->execute();
    $result_nomes_adicionados = $stmt_nomes_adicionados->get_result();
    $qtd_nomes_adicionados = $result_nomes_adicionados->num_rows;
} else {
    echo "ID do grupo não especificado.";
    exit();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="PT-BR" data-bs-theme="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/styledashboard.css">
    <link rel="website icon" type="png" href="imagens/PELADA.PNG">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Sedgwick+Ave+Display&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
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
            <div class="col-12 col-sm-12">
                <h1 class="nGrup"><?php echo htmlspecialchars($nomeGrupo); ?></h1>
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-sm-12">
                <p class="qntResult">O grupo contém <b><?php echo ($qtd_nomes_adicionados + $qtd); ?></b> jogador(es)</p>
            </div>
        </div>
        <div class="row">
            <div class="col-12 text-center">
                <div class="container">
                    <div class="row">
                        <div class="col-md-6 offset-md-3">
                            <form action="paginaGrupo.php?idGrupo=<?php echo $idGrupo; ?>" method="post">
                                <div class="mb-2">
                                    <label for="nameInput" class="form-label">Adicionar Jogadores:</label>
                                    <textarea class="form-control" id="nameInput" name="nameInput" rows="1" placeholder="Digite os nomes dos jogadores" required></textarea>
                                </div>
                                <div class="mb-2">
                                <button type="submit" class="btn btn-primary">Inserir</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <form action="sortearTime.php?idGrupo=<?php echo $idGrupo; ?>" method="POST">
            <div class="row">
                <div class="col-12">
                    <?php if ($result_nomes_adicionados && $result_nomes_adicionados->num_rows > 0) : ?>
                        <table class="table table-bordered table-striped table-hover">
                            <thead>
                                <tr>
                                    <th style="text-align: center">Jogador</th>
                                    <th style="text-align: center">Ação</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($row = $result->fetch_assoc()) : ?>
                                    <?php if (isset($row["nomeJogador"])) : ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars($row["nomeJogador"]); ?></td>
                                        </tr>
                                    <?php endif; ?>
                                <?php endwhile; ?>
                                <?php while ($row_nomes_adicionados = $result_nomes_adicionados->fetch_assoc()) : ?>
                                    <tr>
                                        <td>
                                            <span id="player-name-<?php echo $row_nomes_adicionados['idadicionarNome']; ?>">
                                                <?php echo htmlspecialchars($row_nomes_adicionados['nameInput']); ?>
                                            </span>
                                        </td>
                                        <td>
                                            <form method="post" style="display: inline; text-align: center">
                                                <input type="hidden" name="deletePlayer" value="<?php echo $row_nomes_adicionados['idadicionarNome']; ?>">
                                                <button type="submit" class="btn btn-danger"><span class="material-symbols-outlined">delete_forever</span></button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    <?php else : ?>
                        <p>Nenhum jogador adicionado.</p>
                    <?php endif; ?>
                </div>
            </div>
            <div class="row">
                <div class="col-12 text-center">
                    <label for="numJogadores">N° jogadores por time:</label>
                    <input type="number" id="numJogadores" name="numJogadores" placeholder="2" min="1" required>
                    <button type="submit" class="btn btn-success">sortear</button>
                </div>
            </div>
        </form>
    </div> <!-- FIM CONTAINER-->

    <div class="row">
        <div class="col-12 text-center">
            <div class="btnVoltPgGrup">
            <a href="seusGrupos.php" class="btn btn-secondary"> Voltar</a>
            </div>
        </div>
    </div>
    <script type="text/javascript" src="js/bootstrap.bundle.min.js"></script>
</body>

</html>