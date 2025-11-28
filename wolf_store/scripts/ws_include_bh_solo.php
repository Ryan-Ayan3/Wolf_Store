<?php
    session_start();
    require_once('../conn/conn.php');
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $idbh = intval($_POST['idbh']); //Conversor para tipo INT. Medida de segurança
        $funcionario = intval($_POST['funcionario']); //Conversor para tipo INT. Medida de segurança
        $mes = 0;
        $sql_func = mysqli_query($conn, "SELECT matr FROM funcionario WHERE ativo=1 AND id=$funcionario") or die(mysqli_error($conn));
        $row_func = mysqli_fetch_assoc($sql_func);
        $matr = $row_func['matr'];
        while ($mes >= 0 AND $mes <= 12) {
            $sql = "INSERT INTO banco_horas_func (fk_banco_horas, fk_matr, mes, tipo_saldo, criado, ativo) VALUES ('$idbh','$matr','$mes','0','$dt_hr','1')";
            mysqli_query($conn, $sql) or die(mysqli_error($conn));
            $mes++;
        }
        echo "ok";
        exit;
            
        }
?>