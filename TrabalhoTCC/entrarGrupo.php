<?php
include('config.php');
session_start();

// Verifica se o usuário está logado (se o idJogador está na sessão)
if (isset($_SESSION['emailJogador'])) {
    $emailJogador = $_SESSION['emailJogador'];
}
    $stmt = $conn->prepare("SELECT idJogador FROM jogador WHERE emailJogador = ?");
    $stmt->bind_param("s", $emailJogador);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $idJogador = $row['idJogador'];
    // Obtém o id do jogador da sessão

    // Verifica se o id do grupo está sendo passado via GET e não está vazio
    if (isset($_GET['idGrupo']) && !empty($_GET['idGrupo'])) {
        // Obtém o id do grupo da URL
        $idGrupo = $_GET['idGrupo'];

        // Insere o jogador no grupo na tabela grupo_has_jogador
        $sql = "INSERT INTO grupo_has_jogador (grupo_idGrupo, jogador_idJogador) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);

        if ($stmt) {
            // Vincula os parâmetros
            $stmt->bind_param("ii", $idGrupo, $idJogador);

            // Executa a inserção
            if ($stmt->execute()) {
                // Redireciona de volta para a página do grupo ou para onde preferir
                header("Location: dashboard.php?idGrupo=" . $idGrupo);
                exit();
            } else {
                echo "Erro ao entrar no grupo: " . $conn->error;
            }
            $stmt->close();
        } else {
            echo "Erro na preparação da consulta: " . $conn->error;
        }
    } else {
        echo "ID do grupo não fornecido ou inválido.";
    }
} else {
    echo "Usuário não está logado.";
}
$conn->close();
?>
