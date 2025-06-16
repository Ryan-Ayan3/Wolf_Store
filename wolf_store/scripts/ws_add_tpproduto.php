<?php
    require_once('../conn/conn.php');
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $nome = trim(mysqli_real_escape_string($conn,$_POST['nome']));
        
        $sql = mysqli_query($conn, "INSERT INTO tipo_produto(
                                                    nome, 
                                                    criado, 
                                                    ativo) 
                                                VALUES(
                                                    '$nome',
                                                    '$dt_hr',
                                                    1)") or die(mysqli_error($conn));

        echo "ok";
    }
?>