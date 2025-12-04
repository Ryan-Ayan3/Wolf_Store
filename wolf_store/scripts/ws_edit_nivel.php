<?php
    require_once('../conn/conn.php');
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $id_edit2 = intval($_POST['id']); //Conversor para tipo INT. Medida de segurança
        $tabela_edit2 = preg_replace('/[^a-zA-Z0-9_]/', '', $_POST['tabela']); //Sanitização para permisão somente de letras, números e underline. Medida de segurança
        $nome = trim(mysqli_real_escape_string($conn,strtolower($_POST['nome'])));
        $sql_temp = mysqli_query($conn, "SELECT * FROM $tabela_edit2 WHERE ativo=1 AND nome='$nome' AND id <> $id_edit2") or die(mysqli_error($conn));
        if (mysqli_num_rows($sql_temp) > 0) {
            echo "Já existe um Nível com esse nome";
            exit;
        }

        $alterar_f = $dt_hr;
        
        $sql3 = mysqli_query($conn,"UPDATE $tabela_edit2 
                                        SET 
                                            nome='$nome',
                                            alterado='$alterar_f' 
                                        WHERE id=$id_edit2") or die(mysqli_error($conn));
        
        echo "ok";
    }
?>