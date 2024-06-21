<?php
session_start();
if (empty($_SESSION)){
    header("Location: index.php");
}


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
</head>
<body>
            <div class="container-princial">
                <header>
                    <img class="logo-pagina" src="PELADA.PNG"C:\xampp\htdocs\TrabalhoTCC alt="TrabalhoTCC" width="150x150">
                    <h5 class="nome-pagina">Pelada Futebol Clube</h5>
                        <div class="boas-vindas">
                            <?php
                                print "Olá, "  . $_SESSION["nomeJogador"];
                                
                                print "<a class='link-sair 'href='logout.php' class='btnbtn-danger'>Sair</a>";
                            ?>
                        </div>
                        <div class="listar-grupo">
                        <?php
                                include('config.php');

                                // Verifica se o usuário está logado (se o idJogador está na sessão)
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

                                    $stmt = $conn->prepare($sql);

                                    if ($stmt) {
                                        // Vincula o parâmetro
                                        $stmt->bind_param("i", $idJogador);

                                        // Executa a consulta
                                        if ($stmt->execute()) {
                                            $result = $stmt->get_result();

                                            if ($result->num_rows > 0) {
                                                // Exibe a lista de grupos
                                            
                                                echo "<h2>Grupos em que você está:</h2>";
                                                echo "<table class='tablemygrup table-bordered table-striped table-houver'>";
                                                echo "<tr><th>Nome do Grupo</th><th>Descrição do Grupo</th><th>Detalhes do Grupo</th></tr>";
                                                
                                                while ($row = $result->fetch_assoc()) {
                                                    echo "<tr>";
                                                    echo "<td>" . $row['nomeGrupo'] . "</td>";
                                                    echo "<td>" . $row['descricaoGrupo'] . "</td>";
                                                    echo "<td><a href='paginaGrupo.php?idGrupo=" . $row['idGrupo'] . "'>Detalhes do Grupo</a></td>";
                                                    echo "</tr>";
                                                } 
                                                print"</table>";
                                                
                                            } else {
                                                echo "Você ainda não entrou em nenhum grupo.";
                                            }
                                        } else {
                                            echo "Erro ao executar a consulta: " . $conn->error;
                                        }
                                        $stmt->close();
                                    } else {
                                        echo "Erro na preparação da consulta: " . $conn->error;
                                    }
                                } else {
                                    echo "Usuário não está logado.";
                                }
                                $conn->close();
                                ?>

                          
                    </nav> 
</body>    
</html>