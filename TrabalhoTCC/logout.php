<?php
session_start();

// Certifique-se de verificar se as variáveis de sessão existem antes de removê-las
if (isset($_SESSION["emailJogador"])) {
    unset($_SESSION["emailJogador"]);
}
if (isset($_SESSION["nomeJogador"])) {
    unset($_SESSION["nomeJogador"]);
}

// Destrua a sessão
session_destroy();

// Redirecione para a página inicial
header("Location: index.php");
exit;
?>