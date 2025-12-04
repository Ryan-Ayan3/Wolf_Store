<?php
    require_once('../conn/conn.php');
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $login = trim(mysqli_real_escape_string($conn,$_POST['login']));
        $temp1 = trim(mysqli_real_escape_string($conn,$_POST['senha']));
        $temp2 = password_hash($temp1, PASSWORD_DEFAULT);
        $nivel = trim(mysqli_real_escape_string($conn,$_POST['nivel']));
        $email = trim(mysqli_real_escape_string($conn,$_POST['email']));
        $cargo = trim(mysqli_real_escape_string($conn,$_POST['cargo']));
        $nome = trim(mysqli_real_escape_string($conn,$_POST['nome']));
        
        $sql = mysqli_query($conn, "INSERT INTO usuario(
                                                    login, 
                                                    senha, 
                                                    fk_nivel, 
                                                    email, 
                                                    cargo, 
                                                    nome, 
                                                    criado, 
                                                    ativo) 
                                                VALUES(
                                                    '$login',
                                                    '$temp2',
                                                    '$nivel',
                                                    '$email',
                                                    '$cargo',
                                                    '$nome',
                                                    '$dt_hr',
                                                    1)") or die(mysqli_error($conn));

        echo "ok";
    }
?>