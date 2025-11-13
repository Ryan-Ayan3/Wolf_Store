<?php
    session_start();
    require_once('../conn/conn.php');
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $id_naveg = intval($_POST['id']); //Conversor para tipo INT. Medida de segurança
        $dest_naveg = preg_replace('/[^a-zA-Z0-9_]/', '', $_POST['dest']); //Sanitização para permisão somente de letras, números e underline. Medida de segurança

        $_SESSION['id_naveg'] = $id_naveg;
        $_SESSION['dest_naveg'] = $dest_naveg;

        echo "ok";
    } else {
        echo "Não foi possível realizar a operação";
    }
?>