<?php
    require_once('../conn/conn.php');
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $id_edit2 = intval($_POST['id']); //Conversor para tipo INT. Medida de segurança
        $tabela_edit2 = preg_replace('/[^a-zA-Z0-9_]/', '', $_POST['tabela']); //Sanitização para permisão somente de letras, números e underline. Medida de segurança

        $nome_f = trim(mysqli_real_escape_string($conn, $_POST['nome']));
        $tipo_f = trim(mysqli_real_escape_string($conn, $_POST['tipo']));
        $alterar_f = $dt_hr;
        
        $sql3 = mysqli_query($conn,"UPDATE $tabela_edit2 
                                        SET 
                                            nome='$nome_f',
                                            tipo='$tipo_f',
                                            alterado='$alterar_f' 
                                        WHERE id=$id_edit2") or die(mysqli_error($conn));
        
        echo "ok";
    }
?>