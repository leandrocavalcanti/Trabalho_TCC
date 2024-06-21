<?php
include('config.php');
$emailJogador = $_POST["emailJogador"];
    
    // Verifique se o e-mail já existe no banco de dados
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $acao = $_POST['acao'] ?? '';
    
        if ($acao == 'cadastrar') {
            $nomeJogador = $_POST['nomeJogador'] ?? '';
            $idadeJogador = $_POST['idadeJogador'] ?? '';
            $telefoneJogador = $_POST['telefoneJogador'] ?? '';
            $emailJogador = $_POST['emailJogador'] ?? '';
            $senhaJogador = $_POST['senhaJogador'] ?? '';
    
            // Verifique se todos os campos obrigatórios foram preenchidos
            if (empty($nomeJogador) || empty($idadeJogador) || empty($telefoneJogador) || empty($emailJogador) || empty($senhaJogador)) {
                echo '<div class="alert alert-danger mt-3"><p>Preencha todos os campos obrigatórios.</p></div>';
                echo "<a href='cadastroJogador.php' class='btn btn-danger'>Voltar</a>";
                exit();
            }
    
            // Verifique se o e-mail já existe no banco de dados
            $sql = "SELECT * FROM jogador WHERE emailJogador = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $emailJogador);
            $stmt->execute();
            $res = $stmt->get_result();
    
            if ($res->num_rows > 0) {
                echo '<div class="alert alert-danger mt-5"><p>E-mail já cadastrado. Escolha outro e-mail.</p></div>';
                echo "<a href='cadastroJogador.php' class='btn btn-danger'>Voltar</a>";
            } else {
                $sql = "INSERT INTO jogador (nomeJogador, idadeJogador, telefoneJogador, emailJogador, senhaJogador) VALUES (?, ?, ?, ?, ?)";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("sisss", $nomeJogador, $idadeJogador, $telefoneJogador, $emailJogador, $senhaJogador);
    
                if ($stmt->execute()) {
                    echo "<div class='alert alert-success mt-5'><p>Cadastro realizado com sucesso!</p></div>";
                    echo "<a href='index.php' class='btn btn-success'>Ir para página de login</a>";
                } else {
                    echo "<div class='alert alert-danger mt-5'><p>Erro ao cadastrar!</p></div>";
                    echo "<a href='cadastroJogador.php' class='btn btn-danger'>Voltar</a>";
                }
            }
        } else {
            echo "<div class='alert alert-danger mt-5'><p>Ação desconhecida.</p></div>";
            echo "<a href='cadastroJogador.php' class='btn btn-danger'>Voltar</a>";
        }
    } else {
        echo "<div class='alert alert-danger mt-5'><p>Requisição inválida.</p></div>";
        echo "<a href='cadastroJogador.php' class='btn btn-danger'>Voltar</a>";
    }
     
?>