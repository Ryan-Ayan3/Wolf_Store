<?php
    session_start();
    require_once('../conn/conn.php');
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $id_nivel = intval($_POST['id']); //Conversor para tipo INT. Medida de segurançamisão somente de letras, números e underline. Medida de segurança

        $_SESSION['id_nivel'] = $id_nivel;

        echo "ok";
    } else {
        echo "Não foi possível realizar a operação";
    }
?>