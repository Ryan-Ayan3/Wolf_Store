<?php

    require_once('../conn/conn.php');
    $id_del = intval($_POST['id']); //Conversor para tipo INT. Medida de segurança
    $tabela_del = preg_replace('/[^a-zA-Z0-9_]/', '', $_POST['tabela']); //Sanitização para permisão somente de letras, números e underline. Medida de segurança

    $sql_dell = mysqli_query($conn, "UPDATE $tabela_del SET ativo=0 WHERE id=$id_del") or die(mysqli_error($conn));

    echo "ok";
    
?>