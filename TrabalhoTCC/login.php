<?php
    ob_start();
    session_start();

    if (empty($_POST) or (empty($_POST["emailJogador"]) or (empty($_POST["senhaJogador"])))){
        header("Location: index.php");

    }
    
    include('config.php');

    if (isset($_POST['emailJogador'])) {
        $emailJogador = $_POST['emailJogador'];
        // Resto do código de processamento do login
    } else {
        echo "O campo 'emailJogador' não foi enviado no formulário.";
    }
    if (isset($_POST['senhaJogador'])) {
        $senhaJogador = $_POST['senhaJogador'];
        // Resto do código de processamento do login
    } else {
        echo "O campo 'senhaJogador' não foi enviado no formulário.";
    }

        $sql = "SELECT * FROM Jogador WHERE emailJogador = ? AND senhaJogador = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $emailJogador, $senhaJogador);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_object();
            $_SESSION["emailJogador"] = $emailJogador;
            $_SESSION["nomeJogador"] = $row->nomeJogador;
            header("Location: dashboard.php");
        } else {
            print '<script>alert("Usuário e/ou senha incorreto(s)")</script>';
            header("Location: index.php");
        }
ob_end_flush();
?>