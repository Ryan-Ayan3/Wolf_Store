<?php
    require_once('../conn/conn.php');
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $id_inclu = intval($_POST['id']); //Conversor para tipo INT. Medida de segurança
        $tabela_inclu = preg_replace('/[^a-zA-Z0-9_]/', '', $_POST['tabela']); //Sanitização para permisão somente de letras, números e underline. Medida de segurança

        $sql_inclu = mysqli_query($conn, "SELECT * FROM banco_horas_func WHERE fk_banco_horas=$id_inclu AND ativo=1") or die(mysqli_error($conn));
        $sql_db = mysqli_query($conn, "SELECT ano FROM $tabela_inclu WHERE id=$id_inclu AND ativo=1") or die(mysqli_error($conn));
        $row_db = mysqli_fetch_assoc($sql_db);

        if (mysqli_num_rows($sql_inclu) > 0) {
            echo "Já existe funcionário incluído no ano ".$row_db['ano'];
            exit;
        } else {
            $sql = mysqli_query($conn, "INSERT INTO banco_horas_func(
                                                    fk_banco_horas,
                                                    fk_matr,
                                                    mes,
                                                    tipo_saldo,
                                                    saldo,
                                                    criado, 
                                                    ativo) 
                                                VALUES
                                                    ('$banco_horas', '$matr', '', '1','$','$dt_hr',1),"),
                                                    () or die(mysqli_error($conn));
            echo "ok";
        }

    } else {
        echo "Não foi possível realizar a operação";
    }
?>