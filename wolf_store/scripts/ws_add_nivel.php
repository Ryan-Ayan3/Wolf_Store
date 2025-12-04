<?php
    require_once('../conn/conn.php');
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $nome = trim(mysqli_real_escape_string($conn,strtolower($_POST['nome'])));
        $sql_temp = mysqli_query($conn, "SELECT * FROM nivel WHERE ativo=1 AND nome='$nome'") or die(mysqli_error($conn));
        if (mysqli_num_rows($sql_temp) > 0) {
            echo "Já existe um Nível com essa nome";
            exit;
        }
        $sql = mysqli_query($conn, "INSERT INTO nivel(
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