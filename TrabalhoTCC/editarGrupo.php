<?php
session_start();


?>
<!DOCTYPE html>
<html lang="en" data-bs-theme="light">

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
    <?php

    include('config.php');

    $idGrupo = "";

    if (isset($_SESSION['emailJogador'])) {
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

    if (isset($_GET['idGrupo'])) {
        $idGrupo = $_GET['idGrupo'];
    }

    $sql = "SELECT * FROM grupo WHERE idGrupo = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $idGrupo);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_object();
    ?>
    <div class="row">
        <div class="col-12 text-center">
            <p class="nGrup">Editar grupo: </p>
        </div>
    </div>

    <main class="w-100 m-auto form-container">
        <div class="row">
            <div class="col-12 text-center">
                <form class="editAtulizar" action="salvargrupo.php" method="POST">
                    <input type="hidden" name="acao" value="editarGrupo">
                    <input type="hidden" name="idGrupo" value="<?php echo $idGrupo; ?>">
                    <div class="form-group col-lg-12">
                        <label for="nomeGrupo"><strong>Insira um novo nome: </strong></label>
                        <input type="text" name="nomeGrupo" id="nomeGrupo" class="form-control" value="<?php echo isset($row->nomeGrupo) ? $row->nomeGrupo : ''; ?>">
                    </div>
                    <div class="form-group col-lg-12">
                        <label for="diaSemana"><strong>Novo dia para o jogo: </strong></label>
                        <select id="diaSemana" name="diaSemana" class="form-control">
                            <option value=""> -- </option>
                            <option value="Segunda-feira" <?php echo (isset($row->diaSemana) && $row->diaSemana == "Segunda-feira") ? "selected" : ""; ?>>Segunda-feira</option>
                            <option value="Terça-feira" <?php echo (isset($row->diaSemana) && $row->diaSemana == "Terça-feira") ? "selected" : ""; ?>>Terça-feira</option>
                            <option value="Quarta-feira" <?php echo (isset($row->diaSemana) && $row->diaSemana == "Quarta-feira") ? "selected" : ""; ?>>Quarta-feira</option>
                            <option value="Quinta-feira" <?php echo (isset($row->diaSemana) && $row->diaSemana == "Quinta-feira") ? "selected" : ""; ?>>Quinta-feira</option>
                            <option value="Sexta-feira" <?php echo (isset($row->diaSemana) && $row->diaSemana == "Sexta-feira") ? "selected" : ""; ?>>Sexta-feira</option>
                            <option value="Sábado" <?php echo (isset($row->diaSemana) && $row->diaSemana == "Sábado") ? "selected" : ""; ?>>Sábado</option>
                            <option value="Domingo" <?php echo (isset($row->diaSemana) && $row->diaSemana == "Domingo") ? "selected" : ""; ?>>Domingo</option>
                        </select>
                    </div>
                    <div class="form-group col-lg-12">
                        <label for="horaJogo"><strong>Novo horário: </strong></label>
                        <input type="time" name="horaJogo" id="horaJogo" class="form-control" value="<?php echo isset($row->horaJogo) ? $row->horaJogo : ''; ?>" placeholder="00:00">
                    </div>
                    <div class="form-group col-lg-12">
                        <label for="descricaoGrupo"><strong>Nova descrição do grupo</strong></label>
                        <textarea class="form-control" id="descricaoGrupo" name="descricaoGrupo" rows="3"><?php echo isset($row->descricaoGrupo) ? $row->descricaoGrupo : ''; ?></textarea>
                    </div>

                    <div class="btnAtualiza">
                        <button type="submit" class="btn btn-primary w-90">Atualizar</button>
                        <a href="seusGrupos.php" class="btn btn-secondary w-90">Voltar</a>
                    </div>
                        
                    
                </form>
            </div>

        </div>
    </main>
    <div class="btnVGrup">
        <div class="row">

        </div>
    </div>

    <script type="text/javascript" src="js/bootstrap.bundle.min.js"></script>

</body>

</html>