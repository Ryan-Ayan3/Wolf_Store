<?php
    require_once('../conn/conn.php');
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $nome = trim(mysqli_real_escape_string($conn,$_POST['nome']));
        $tipoValor = intval($_POST['tipoValor']);
        
        $sql = mysqli_query($conn, "INSERT INTO unidade_medida(
                                                    nome,
                                                    tipovalor,
                                                    criado, 
                                                    ativo) 
                                                VALUES(
                                                    '$nome',
                                                    '$tipoValor',
                                                    '$dt_hr',
                                                    1)") or die(mysqli_error($conn));

        echo "ok";
    }
?>