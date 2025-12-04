<?php
    require_once('../conn/conn.php');
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $id_edit2 = intval($_POST['id']); //Conversor para tipo INT. Medida de segurança
        $tabela_edit2 = preg_replace('/[^a-zA-Z0-9_]/', '', $_POST['tabela']); //Sanitização para permisão somente de letras, números e underline. Medida de segurança

        $login_f = trim(mysqli_real_escape_string($conn, strtolower($_POST['login'])));
        $nivel_f = trim(mysqli_real_escape_string($conn, $_POST['nivel']));
        $email_f = trim(mysqli_real_escape_string($conn, $_POST['email']));
        $cargo_f = trim(mysqli_real_escape_string($conn, $_POST['cargo']));
        $nome_f = trim(mysqli_real_escape_string($conn, $_POST['nome']));
        $senha_f = mysqli_real_escape_string($conn, $_POST['nova_senha']);
        $alterar_f = $dt_hr;
        
        if ($_POST['nova_senha'] != NULL) {
            $senha_f = password_hash($_POST['nova_senha'], PASSWORD_DEFAULT);
            $sql3 = mysqli_query($conn,"UPDATE $tabela_edit2 
                                        SET 
                                            login='$login_f',
                                            senha='$senha_f',
                                            fk_nivel='$nivel_f',
                                            email='$email_f',
                                            cargo='$cargo_f',
                                            nome='$nome_f',
                                            alterado='$alterar_f' 
                                        WHERE id=$id_edit2") or die(mysqli_error($conn));
        } else {
            $sql3 = mysqli_query($conn,"UPDATE $tabela_edit2 
                                        SET 
                                            login='$login_f',
                                            nivel='$nivel_f',
                                            fk_email='$email_f',
                                            cargo='$cargo_f',
                                            nome='$nome_f',
                                            alterado='$alterar_f' 
                                        WHERE id=$id_edit2") or die(mysqli_error($conn));
        }
        
        echo "ok";
    }
?>