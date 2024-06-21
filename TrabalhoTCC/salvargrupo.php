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
    
        switch ($_REQUEST["acao"]) {
            case 'cadastrarGrupo':
                $nomeGrupo = $_POST["nomeGrupo"];
                $diaSemana = $_POST["diaSemana"];
                $horaJogo = $_POST["horaJogo"];
                $descricaoGrupo = $_POST["descricaoGrupo"];

                if (empty($nomeGrupo) || empty($diaSemana) || empty($horaJogo) || empty($descricaoGrupo)){
                    echo '<div class="alert alert-danger mt-3"><p>Preencha todos os campos obrigatórios.</p></div>';
                } else {
                    $sql = "INSERT INTO grupo (
                                nomeGrupo,
                                diaSemana,
                                horaJogo,
                                descricaoGrupo,
                                idCriador
                            ) VALUES (
                                '$nomeGrupo',
                                '$diaSemana',
                                '$horaJogo',
                                '$descricaoGrupo',
                                '$idJogador'
                            )";

                    $result = $conn->query($sql) or die($conn->error);

                    if ($result === true) {
                        $idGrupo = $conn->insert_id;

                        $sqlInsertJogador = "INSERT INTO grupo_has_jogador (grupo_idGrupo, jogador_idJogador) VALUES ('$idGrupo', '$idJogador')";
                        $resultInsertJogador = $conn->query($sqlInsertJogador) or die($conn->error);

                        if ($resultInsertJogador === true) {
                            echo "<div class='alert alert-success mt-5'><p>Grupo criado com sucesso!!</p></div>";
                            header("Location: paginaGrupo.php?idGrupo=$idGrupo");
                            exit();
                        } else {
                            echo "<div class='alert alert-danger mt-5'><p>Erro ao adicionar o jogador ao grupo.</p></div>";
                        }
                    } else {
                        echo "<div class='alert alert-danger mt-5'><p>Erro ao cadastrar o grupo.</p></div>";
                    }
                }
                break;

            case 'editarGrupo':
                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    if (isset($_POST["idGrupo"])) {
                        $idGrupo = $_POST["idGrupo"];
                        $nomeGrupo = $_POST["nomeGrupo"];
                        $diaSemana = $_POST["diaSemana"];
                        $horaJogo = $_POST["horaJogo"];
                        $descricaoGrupo = $_POST["descricaoGrupo"];
                        
                        $sql = "UPDATE grupo SET ";
                        $params = [];
                        $atualizacaoRealizada = false;

                        if (!empty($nomeGrupo)) {
                            $sql .= "nomeGrupo = ?, ";
                            $params[] = $nomeGrupo;
                            $atualizacaoRealizada = true;
                        }

                        if (!empty($diaSemana)) {
                            $sql .= "diaSemana = ?, ";
                            $params[] = $diaSemana;
                            $atualizacaoRealizada = true;
                        }

                        if (!empty($horaJogo)) {
                            $sql .= "horaJogo = ?, ";
                            $params[] = $horaJogo;
                            $atualizacaoRealizada = true;
                        }

                        if (!empty($descricaoGrupo)) {
                            $sql .= "descricaoGrupo = ?, ";
                            $params[] = $descricaoGrupo;
                            $atualizacaoRealizada = true;
                        }

                        $sql = rtrim($sql, ", ");
                        $sql .= " WHERE idGrupo = ?";
                        $params[] = $idGrupo;

                        if ($atualizacaoRealizada) {
                            $stmt = $conn->prepare($sql);
                            if ($stmt) {
                                $types = str_repeat('s', count($params));
                                $stmt->bind_param($types, ...$params);
                                $stmt->execute();

                                if ($stmt->affected_rows > 0) {
                                    echo "Atualização realizada com sucesso!";
                                    header("Location: seusGrupos.php");
                                } else {
                                    echo "Nenhuma atualização foi feita.";
                                }
                            } else {
                                echo "Erro na preparação da declaração: " . $conn->error;
                            }
                        }
                        $stmt->close();
                    }
                }
                break;

                case 'excluirGrupo':
                    if ($_REQUEST["acao"] === 'excluirGrupo') {
                        if (isset($_GET['idGrupo'])) {
                            $idGrupo = $_GET['idGrupo'];
    
                            // Verificar se o jogador é o criador do grupo
                            $stmtVerificaCriador = $conn->prepare("SELECT idCriador FROM grupo WHERE idGrupo = ?");
                            $stmtVerificaCriador->bind_param("i", $idGrupo);
                            $stmtVerificaCriador->execute();
                            $resultVerificaCriador = $stmtVerificaCriador->get_result();
    
                            if ($resultVerificaCriador->num_rows > 0) {
                                $rowVerificaCriador = $resultVerificaCriador->fetch_assoc();
                                $idCriadorGrupo = $rowVerificaCriador['idCriador'];
    
                                if ($idCriadorGrupo == $idJogador) {
                                    // O jogador é o criador do grupo, pode excluir
                                    $sqlDeleteDependencias = "DELETE FROM adicionarnome WHERE Grupo_idGrupo = ?";
                                    $stmtDeleteDependencias = $conn->prepare($sqlDeleteDependencias);
                                    $stmtDeleteDependencias->bind_param("i", $idGrupo);
                                    $stmtDeleteDependencias->execute();
    
                                    $sqlDeleteGrupo = "DELETE FROM grupo WHERE idGrupo = ?";
                                    $stmtDeleteGrupo = $conn->prepare($sqlDeleteGrupo);
                                    $stmtDeleteGrupo->bind_param("i", $idGrupo);
                                    $stmtDeleteGrupo->execute();
    
                                    if ($stmtDeleteGrupo->affected_rows > 0) {
                                        echo "<div class='alert alert-success mt-5'><p>Excluído com sucesso!</p></div>";
                                        echo "<a href='seusGrupos.php' class='btn btn-danger'>Voltar para página inicial</a>";
                                        exit();
                                    } else {
                                        echo "<div class='alert alert-danger mt-5'><p>Erro ao excluir!</p></div>";
                                    }
    
                                    $stmtDeleteDependencias->close();
                                    $stmtDeleteGrupo->close();
                                } else {
                                    echo "<div class='alert alert-danger mt-5'><p>Você não tem permissão para excluir este grupo.</p></div>";
                                }
                            } else {
                                echo "<div class='alert alert-danger mt-5'><p>Grupo não encontrado.</p></div>";
                            }
    
                            $stmtVerificaCriador->close();
                        }
                        header("Location:seusGrupos.php");
                    }
                    break;
            }
        }
    }
    
    $conn->close();
    ?>
