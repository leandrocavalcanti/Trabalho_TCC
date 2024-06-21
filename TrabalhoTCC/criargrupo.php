<?php
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
        $idJogador = $row['idCriador'];
    }
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


    <main class="w-100 m-auto form-container">
        <div class="row">
            <div class="col-12 text-center ">
                <p class="nGrup">Criar Jogo</p>
            </div>
        </div>

        <form action="salvargrupo.php" method="POST" onsubmit="return validarCadastro();">
            <input type="hidden" name="acao" value="cadastrarGrupo">
            <div class="form-group">
                <label for="nomeGrupo"><strong>Nome do Grupo: </strong></label>
                <input type="text" name="nomeGrupo" id="nomeGrupo" class="form-control" placeholder="nome do grupo">
            </div>
            <div class="form-group">
                <label for="diaSemana"><strong>Quando será o jogo? </strong></label>
                <select id="diaSemana" name="diaSemana" class="form-control">
                    <option value=""> -- </option>
                    <option value="Segunda-feira">Segunda-feira</option>
                    <option value="Terça-feira">Terça-feira</option>
                    <option value="Quarta-feira">Quarta-Feira</option>
                    <option value="Quinta-feira">Quinta-Feira</option>
                    <option value="Sexta-feira">Sexta-feira</option>
                    <option value="Sábado">Sábado</option>
                    <option value="Domingo">Domingo</option>
                </select>
            </div>
            <div class="form-group">
                <label for="horaJogo"><strong>Horario: </strong></label>
                <input type="time" name="horaJogo" id="horaJogo" class="form-control" placeholder="00:00">
            </div>
            <div class="form-group">
                <label for="descricaoGrupo"><strong>Descrição do grupo</strong></label>
                <textarea class="form-control" id="descricaoGrupo" name="descricaoGrupo" rows="3"></textarea>
            </div>
            <div class="btnCriarGrup">
                <button type="submit" class="btn btn-primary w-100 " onclick="return validarCadastro();">Criar</button>
                <a href="dashboard.php" class="btn btn-secondary w-100">Voltar</a>
            </div>
        </form>
        <a href="seusGrupos.php"></a>
    </main>
    </div>
    <script>
        function validarCadastro() {
            var nomeGrupo = document.getElementById("nomeGrupo").value;
            var diaSemana = document.getElementById("diaSemana").value;
            var horaJogo = document.getElementById("horaJogo").value;
            var descricaoGrupo = document.getElementById("descricaoGrupo").value;

            if (nomeGrupo === "" || diaSemana === "" || horaJogo === "" || descricaoGrupo === "") {
                alert("Por favor, preencha todos os campos obrigatórios.");
                return false; // Impede o envio do formulário
            }
        }
    </script>
<script type="text/javascript" src="js/bootstrap.bundle.min.js"></script>
</body>

</html>