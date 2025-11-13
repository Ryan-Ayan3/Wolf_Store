<?php
    require_once('../conn/conn.php');
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $id_del = intval($_POST['id']); //Conversor para tipo INT. Medida de segurança
        $tabela_del = preg_replace('/[^a-zA-Z0-9_]/', '', $_POST['tabela']); //Sanitização para permisão somente de letras, números e underline. Medida de segurança

        $sql_valid = mysqli_query($conn, "SELECT * FROM banco_horas_func WHERE fk_banco_horas=$id_del AND ativo=1") or die(mysqli_error($conn));
        $sql_db = mysqli_query($conn, "SELECT ano FROM $tabela_del WHERE id=$id_del AND ativo=1") or die(mysqli_error($conn));
        $row_db = mysqli_fetch_assoc($sql_db);

        if (mysqli_num_rows($sql_valid) > 0) {
            echo "Já existe funcionário incluído no ano ".$row_db['ano'];
            exit;
        } else {
            $sql_dell = mysqli_query($conn, "UPDATE $tabela_del SET ativo=0,deletado='$dt_hr' WHERE id=$id_del") or die(mysqli_error($conn));
            echo "ok";
        }
    }
?>