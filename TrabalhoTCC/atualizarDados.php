<?php
include('config.php');
session_start();




?>
<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="styledashboard.css">
    <link rel="website icon" type="png" href="PELADA.PNG"C:\xampp\htdocs\TrabalhoTCC>

    <title>Pelada Futebol Clube</title>

    <div class="container-princial">
                <header class="cabecalho">
                    <img class="logo-pagina" src="PeladaFC_ii.png"C:\xampp\htdocs\TrabalhoTCC alt="TrabalhoTCC" width="150x150">
                    <h5 class="nome-pagina">Pelada Futebol Clube</h5>
                        <div class="boas-vindas">
                       
                            <?php
                                print "Olá, "  . $_SESSION["nomeJogador"];
                                
                                print "<a class='link-sair 'href='logout.php' class='btnbtn-danger'>Sair</a>";
                            ?>
    </div>
</head>
<body>
    <?php
if (isset($_SESSION['emailJogador'])) {
    $emailJogador = $_SESSION['emailJogador'];

    // Recupere o ID do jogador
    $stmt = $conn->prepare("SELECT idJogador FROM jogador WHERE emailJogador = ?");
    $stmt->bind_param("s", $emailJogador);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $idJogador = $row['idJogador'];

        // Use o ID do jogador para recuperar o idDadosJogador
        $stmtDados = $conn->prepare("SELECT idDadosJogador FROM dadosjogador WHERE jogador_idJogador = ?");
        $stmtDados->bind_param("i", $idJogador);
        $stmtDados->execute();
        $resultDados = $stmtDados->get_result();

        if ($resultDados->num_rows > 0) {
            $rowDados = $resultDados->fetch_assoc();
            $idDadosJogador = $rowDados['idDadosJogador'];
        }
    }
}
?>
<div class="insertDados">
    <h2 class="loginpalavra">Atualizar dados</h2>
    <br><br>
    <div class="form-group">
        <form action="salvarDados.php" method="POST">
            <input type="hidden" name="acao" value="atualizarDados">
            <input type="hidden" name="idDadosJogador" value="<?php echo $idDadosJogador; ?>">
            <label for="novosGols">Quantidade de novos gols marcados:</label>
            <input type="number" name="novosGols" class="form-control">
    </div>
    <div class="form-group">
        <label for="novasVitorias">Quantidade de novas vitórias:</label>
        <input type="number" name="novasVitorias" class="form-control">
    </div>
    <div class="form-group">
        <label for="novasDerrotas">Quantidade de novas derrotas:</label>
        <input type="number" name="novasDerrotas" class="form-control">
    </div>
    <button type="submit" class="btn btn-primary w-100 py-2">Salvar</button>

</form>
    <form class="btnVoltUp" action="dashboard.php" method="POST">
        <div><br>
            <button type="submit" class="btn btn-primary w-100 py-2">Voltar</button>
        </div>
    </form>
</div>
     
</body>
</html>