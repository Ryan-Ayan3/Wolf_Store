<?php
    require_once('../conn/conn.php');
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $id_edit2 = intval($_POST['id']); //Conversor para tipo INT. Medida de segurança
        $tabela_edit2 = preg_replace('/[^a-zA-Z0-9_]/', '', $_POST['tabela']); //Sanitização para permisão somente de letras, números e underline. Medida de segurança

        $ano_f = trim(mysqli_real_escape_string($conn, $_POST['ano']));
        $alterar_f = $dt_hr;

         if ($ano_f < 2010 || $ano_f > 2100) {
            echo "Apenas são permitidos anos entre 2010 e 2100";
            exit;
        }

        $sql_valid = mysqli_query($conn, "SELECT * FROM banco_horas WHERE ativo=1 AND ano=$ano_f") or die(mysqli_error($conn));
        if (mysqli_num_rows($sql_valid) > 0) {
            echo "Já existe um Banco de Horas com esse ano!";
            exit;
        }

        $sql_valid = mysqli_query($conn, "SELECT * FROM banco_horas_func WHERE fk_banco_horas=$id_del AND ativo=1") or die(mysqli_error($conn));
        $sql_db = mysqli_query($conn, "SELECT ano FROM $tabela_del WHERE id=$id_del AND ativo=1") or die(mysqli_error($conn));
        $row_db = mysqli_fetch_assoc($sql_db);

        if (mysqli_num_rows($sql_valid) > 0) {
            echo "Já existe funcionário incluído no ano ".$row_db['ano'];
        } else {
            $sql3 = mysqli_query($conn,"UPDATE $tabela_edit2 
                                        SET 
                                            ano='$ano_f',
                                            alterado='$alterar_f' 
                                        WHERE id=$id_edit2") or die(mysqli_error($conn));
        
        echo "ok";
        }
    }
?>