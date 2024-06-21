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
    
        <main class="w-100 m-auto form-container">
            <div class="row">
                <div class="col-12 text-center ">
                    <p class="nGrup">Faça seu Cadastro</p>
                    <hr>
                </div>
            </div>

            <form action="salvarJogador.php" method="POST">
                <input type="hidden" name="acao" value="cadastrar">
                <div class="form-group">
                    <label for="nomeJogador"><strong>Nome:</strong></label> <!--Nome do usuario-->
                    <input type="text" name="nomeJogador" id="nomeJogador" class="form-control" placeholder="Fulando Silva" required>

                </div>
                <div class="form-group">
                    <label for="idadeJogador"><strong>Idade:</strong></label><!--idade do usuario-->
                    <input type="number" name="idadeJogador" class="form-control" id="idadeJogador" placeholder="00" required>
                </div>
                <div class="form-group">
                    <label for="telefoneJogador"><strong>Telefone:</strong></label><!--Telefone do usuario-->
                    <input type="text" name="telefoneJogador" class="form-control" id="telefoneJogador" placeholder="(00)9.9999-9999" required>
                </div>
                <div class="form-group">
                    <label for="emailJogador"><strong>E-mail:</strong></label><!--email do usuario-->
                    <input type="email" name="emailJogador" class="form-control" id="emailJogador" placeholder="fulando@algumacoisa.com" required>
                </div>
                <div class="form-group">
                    <label for="senhaJogador"><strong>Senha:</strong></label><!--senha do usuario-->
                    <input type="password" name="senhaJogador" class="form-control" id="senhaInput" placeholder="Senha" required>
                </div>

                <script>
                    function validarCadastro() {
                        var nomeJogador = document.getElementById("nomeJogador").value;
                        var idadeJogador = document.getElementById("idadeJogador").value;
                        var telefoneJogador = document.getElementById("telefoneJogador").value;
                        var emailJogador = document.getElementById("emailJogador").value;
                        var senhaJogador = document.getElementById("senhaJogador").value;

                        if (nomeJogador === "" || idadeJogador === "" || telefoneJogador === "" || emailJogador === "" || senhaJogador === "") {
                            alert("Por favor, preencha todos os campos obrigatórios.");
                            return false; // Impede o envio do formulário
                        }
                    }
                </script>

                <div class="btnCriar">
                    <button type="submit" class="btn btn-primary w-100 py-2" onclick="return validarCadastro();">Cadastrar</button>
                </div>
            </form>
            <form class="btnVltCriar" action="index.php" method="POST">
                <button type="submit" class="btn btn-secondary w-100 py-2">Voltar</button>
            </form>

    </div>
</body>

</html>