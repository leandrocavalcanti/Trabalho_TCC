<?php
include("config.php");

switch ($_REQUEST["acao"]) {

            
    case 'inserirDados':

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['jogador_idJogador'])) {
    $jogador_idJogador = $_POST["jogador_idJogador"];
}
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Recebe os dados do formulário
        $qtdGols = $_POST["qtdGols"];
        $qtdVitoria = $_POST["qtdVitoria"];
        $qtdDerrotas = $_POST["qtdDerrotas"];
    
        // Calcula a quantidade total de partidas
        $qtdPartida = $qtdVitoria + $qtdDerrotas;
    
        // Calcula a média de valor
        if ($qtdPartida > 0) {
            $vlrMedia = ((($qtdVitoria / $qtdPartida) + ($qtdGols / $qtdPartida)) * 0.5) * 10;
        } else {
            $vlrMedia = 0;
        }

        $sql = "INSERT INTO dadosjogador (jogador_idJogador, qtdGols, qtdVitoria, qtdDerrotas, qtdPartida, vlrMedia) VALUES ('$jogador_idJogador', '$qtdGols', '$qtdVitoria', '$qtdDerrotas', '$qtdPartida', '$vlrMedia')";

        // Executa a query
        if ($conn->query($sql) === TRUE) {
            echo "Dados inseridos com sucesso!";
            header("Location: dashboard.php");
        } else {
            echo "Erro ao inserir os dados: " . $conn->error;
        }
    
        // Fecha a conexão
        $conn->close();
    }
    break;
    case 'atualizarDados':
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $idDadosJogador = $_POST["idDadosJogador"];      
    $novosGols = $_POST["novosGols"];
    $novasVitorias = $_POST["novasVitorias"];
    $novasDerrotas = $_POST["novasDerrotas"];

        $novoQtdPartida = $novasVitorias + $novasDerrotas;
    
    // Query para obter os valores atuais do banco de dados
    $sql = "SELECT * FROM dadosjogador WHERE idDadosJogador = $idDadosJogador";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // Soma os valores atuais com os novos valores
        $golsAtualizados = $row["qtdGols"] + $novosGols;
        $vitoriasAtualizadas = $row["qtdVitoria"] + $novasVitorias;
        $derrotasAtualizadas = $row["qtdDerrotas"] + $novasDerrotas;
        $qtdPartidasAtualizadas = $row["qtdPartida"] + $novoQtdPartida;
        $vlrMediaAtualizadas = ((($vitoriasAtualizadas / $qtdPartidasAtualizadas) + ($golsAtualizados / $qtdPartidasAtualizadas)) * 0.5) * 10;

        // Atualiza os valores no banco de dados
        $update_sql = "UPDATE dadosjogador SET qtdGols = $golsAtualizados, qtdVitoria = $vitoriasAtualizadas, qtdDerrotas = $derrotasAtualizadas, 
                                            qtdPartida = $qtdPartidasAtualizadas, vlrMedia = $vlrMediaAtualizadas WHERE idDadosJogador = $idDadosJogador";

        if ($conn->query($update_sql) === TRUE) {
            echo "Dados atualizados com sucesso!";
            header("Location: dashboard.php");
        } else {
            echo "Erro ao atualizar os dados: " . $conn->error;
        }
    } else {
        echo "Nenhum resultado encontrado!";
    }
}else {
    echo "ID dos dados do jogador não encontrado na solicitação!";
}

// Fecha a conexão
$conn->close();
}
?>