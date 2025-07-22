<?php
    require_once('../conn/conn.php');
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $nome = trim(mysqli_real_escape_string($conn,$_POST['nome']));
        $tipo = trim(mysqli_real_escape_string($conn,$_POST['tipo']));
        
        $sql = mysqli_query($conn, "INSERT INTO tipo_movimento(
                                                    nome,
                                                    tipo,
                                                    criado, 
                                                    ativo) 
                                                VALUES(
                                                    '$nome',
                                                    '$tipo',
                                                    '$dt_hr',
                                                    1)") or die(mysqli_error($conn));

        echo "ok";
    }
?>