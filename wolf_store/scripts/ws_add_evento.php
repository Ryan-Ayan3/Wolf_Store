<?php
    require_once('../conn/conn.php');
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $nome = trim(mysqli_real_escape_string($conn,$_POST['nome']));

        $sql_evento = mysqli_query($conn, "SELECT nome FROM evento WHERE nome='$nome' AND ativo=1") or die(mysqli_error($conn));
        if (mysqli_num_rows($sql_evento) > 0) {
            echo "Já existe um Evento com este Nome";
            exit;
        }

        $tipo_saldo = trim(mysqli_real_escape_string($conn,$_POST['tipo_saldo']));
        $funcao = trim(mysqli_real_escape_string($conn,$_POST['funcao']));
        
        $sql = mysqli_query($conn, "INSERT INTO evento(
                                                    nome,
                                                    tipo_saldo,
                                                    funcao,
                                                    criado, 
                                                    ativo) 
                                                VALUES(
                                                    '$nome',
                                                    '$tipo_saldo',
                                                    '$funcao',
                                                    '$dt_hr',
                                                    1)") or die(mysqli_error($conn));

        echo "ok";
    }
?>