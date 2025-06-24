<?php
    require_once('../conn/conn.php');
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        //Validação CNPJ ou CPF
        $cadastro = trim(mysqli_real_escape_string($conn,$_POST['cadastro']));
        if ($cadastro != 0 and strlen($cadastro) == 11) {
            include_once('validar_cpf.php');
            if ($validado == 0) {
                echo "CPF inválido. Verifique se digitou corretamente e coloque apenas números.";
                exit;
            }
        } elseif ($cadastro != 0 and strlen($cadastro) == 14) {
            include_once('validar_cnpj.php');
            if ($validado == 0) {
                echo "CNPJ inválido. Verifique se digitou corretamente e coloque apenas números.";
                exit;
            }
        } elseif ($cadastro != "") {
            echo "Informação Inválida ou insuficiente. Digite apenas números e verifique a informação.";
            exit;
        } else {
            $result1 = "";
        }

        $nome = trim(mysqli_real_escape_string($conn,$_POST['nome']));
        $cadasF = $result1;
        $uf = trim(mysqli_real_escape_string($conn,$_POST['uf']));
        $cep = trim(mysqli_real_escape_string($conn,$_POST['cep']));
        $municipio = trim(mysqli_real_escape_string($conn,$_POST['municipio']));
        $bairro = trim(mysqli_real_escape_string($conn,$_POST['bairro']));
        $rua = trim(mysqli_real_escape_string($conn,$_POST['rua']));
        $endereco = trim(mysqli_real_escape_string($conn,$_POST['endereco']));
        $complemento = trim(mysqli_real_escape_string($conn,$_POST['complemento']));
        $contato = trim(mysqli_real_escape_string($conn,$_POST['contato']));
        $email = trim(mysqli_real_escape_string($conn,$_POST['email']));
        $obs = trim(mysqli_real_escape_string($conn,$_POST['obs']));

        if (strlen($cadasF) == 11 || $cadasF == "") {
            $sql = mysqli_query($conn, "INSERT INTO pessoa(
                                                        nome, 
                                                        cpf, 
                                                        uf, 
                                                        cep, 
                                                        municipio, 
                                                        bairro, 
                                                        rua,
                                                        endereco,
                                                        complemento,
                                                        contato,
                                                        email,
                                                        obs,
                                                        categoria,
                                                        criado,
                                                        ativo) 
                                                    VALUES(
                                                        '$nome',
                                                        '$cadasF',
                                                        '$uf',
                                                        '$cep',
                                                        '$municipio',
                                                        '$bairro',
                                                        '$rua',
                                                        '$endereco',
                                                        '$complemento',
                                                        '$contato',
                                                        '$email',
                                                        '$obs',
                                                        '1',
                                                        '$dt_hr',
                                                        1)") or die(mysqli_error($conn));
        } else {
            $sql2 = mysqli_query($conn, "INSERT INTO pessoa(
                                                        nome, 
                                                        cnpj, 
                                                        uf, 
                                                        cep, 
                                                        municipio, 
                                                        bairro, 
                                                        rua,
                                                        endereco,
                                                        complemento,
                                                        contato,
                                                        email,
                                                        obs,
                                                        categoria,
                                                        criado,
                                                        ativo)
                                                    VALUES(
                                                        '$nome',
                                                        '$cadasF',
                                                        '$uf',
                                                        '$cep',
                                                        '$municipio',
                                                        '$bairro',
                                                        '$rua',
                                                        '$endereco',
                                                        '$complemento',
                                                        '$contato',
                                                        '$email',
                                                        '$obs',
                                                        '1',
                                                        '$dt_hr',
                                                        1)") or die(mysqli_error($conn));
        }

        echo "ok";
    }
?>