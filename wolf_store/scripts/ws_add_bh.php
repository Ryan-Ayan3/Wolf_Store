<?php
    require_once('../conn/conn.php');
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $ano = trim(mysqli_real_escape_string($conn,$_POST['ano']));
        if ($ano < 2010 || $ano > 2100) {
            echo "Apenas são permitidos anos entre 2010 e 2100";
            exit;
        }

        $sql_valid = mysqli_query($conn, "SELECT * FROM banco_horas WHERE ativo=1 AND ano=$ano") or die(mysqli_error($conn));
        
        if (mysqli_num_rows($sql_valid) > 0) {
            echo "Já existe um Banco de Horas com esse ano!";
            exit;
        }
        
        $sql = mysqli_query($conn, "INSERT INTO banco_horas(
                                                    ano,
                                                    encerrado,
                                                    criado, 
                                                    ativo) 
                                                VALUES(
                                                    '$ano',
                                                    '0',
                                                    '$dt_hr',
                                                    1)") or die(mysqli_error($conn));

        echo "ok";
    }
?>