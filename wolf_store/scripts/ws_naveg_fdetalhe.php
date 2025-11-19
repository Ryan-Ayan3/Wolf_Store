<?php
    session_start();
    require_once('../conn/conn.php');
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $id_naveg = intval($_POST['id']); //Conversor para tipo INT. Medida de segurança

        $_SESSION['id_fdetalhe'] = $id_naveg;

        echo "ok";
    } else {
        echo "Não foi possível realizar essa operação";
    }
?>