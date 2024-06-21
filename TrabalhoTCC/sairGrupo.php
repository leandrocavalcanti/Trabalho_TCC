
<?php
session_start();
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

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (isset($_POST["idGrupo"]) && !empty($_POST["idGrupo"])) {
                $idGrupo = $_POST["idGrupo"];

                $sql = "DELETE FROM grupo_has_jogador WHERE grupo_idGrupo = ? AND jogador_idJogador = ?";
                $stmt = $conn->prepare($sql);

                if ($stmt) {
                    $stmt->bind_param("ii", $idGrupo, $idJogador);
                    $stmt->execute();

                    if ($stmt->affected_rows > 0) {
                        echo "Você foi removido do grupo com sucesso!";
                    } else {
                        echo "Erro ao remover você do grupo.";
                    }

                    $stmt->close();
                } else {
                    echo "Erro na preparação da consulta: " . $conn->error;
                }

                $conn->close();
            } else {
                echo "ID do grupo não recebido ou vazio.";
            }
        } else {
            echo "Formulário não enviado corretamente.";
        }
    } else {
        echo "Usuário não encontrado.";
    }

    // Redirecionamento após a execução das operações
    header("Location: seusGrupos.php");
    exit();
} else {
    echo "Sessão 'emailJogador' não encontrada.";
}

?>
