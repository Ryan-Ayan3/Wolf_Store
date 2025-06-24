<?php
    require_once('../conn/conn.php');
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $id_edit2 = intval($_POST['id']); //Conversor para tipo INT. Medida de segurança
        $tabela_edit2 = preg_replace('/[^a-zA-Z0-9_]/', '', $_POST['tabela']); //Sanitização para permisão somente de letras, números e underline. Medida de segurança

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
        $alterar_f = $dt_hr;
        
        if (strlen($cadasF) == 11 || $cadasF == "") {
            $sql3 = mysqli_query($conn,"UPDATE $tabela_edit2 
                                        SET 
                                            nome='$nome',
                                            cpf='$cadasF',
                                            cnpj=NULL,
                                            uf='$uf',
                                            cep='$cep',
                                            municipio='$municpio',
                                            bairro='$bairro',
                                            rua='$rua',
                                            endereco='$endereco',
                                            complemento='$complemento',
                                            contato='$contato',
                                            email='$email',
                                            obs='$obs',
                                            alterado='$alterar_f' 
                                        WHERE id=$id_edit2") or die(mysqli_error($conn));
        } else {
            $sql3 = mysqli_query($conn,"UPDATE $tabela_edit2 
                                        SET 
                                            nome='$nome',
                                            cpf=NULL,
                                            cnpj='$cadasF',
                                            uf='$uf',
                                            cep='$cep',
                                            municipio='$municipio',
                                            bairro='$bairro',
                                            rua='$rua',
                                            endereco='$endereco',
                                            complemento='$complemento',
                                            contato='$contato',
                                            email='$email',
                                            obs='$obs',
                                            alterado='$alterar_f' 
                                        WHERE id=$id_edit2") or die(mysqli_error($conn));
        }
        
        echo "ok";
    }
?>