<?php
    require_once('../conn/conn.php');
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $nome = trim(mysqli_real_escape_string($conn,$_POST['nome']));
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