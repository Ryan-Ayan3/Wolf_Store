<?php
    require_once('../conn/conn.php');
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $codigo = trim(mysqli_real_escape_string($conn,$_POST['codigo']));
        $nome = trim(mysqli_real_escape_string($conn,$_POST['nome']));
        $medida = trim(mysqli_real_escape_string($conn,$_POST['medida']));
        $tipo = trim(mysqli_real_escape_string($conn,$_POST['tipo']));
        $peso = trim(mysqli_real_escape_string($conn,$_POST['peso']));
        $preco = trim(mysqli_real_escape_string($conn,$_POST['preco']));
        $fornecedor = trim(mysqli_real_escape_string($conn,$_POST['fornecedor']));
        $obs = trim(mysqli_real_escape_string($conn,$_POST['obs']));
        
        if($fornecedor == "") {
            echo "Selecione um fornecedor já registrado.";
            exit;
        }

        $sql = mysqli_query($conn, "INSERT INTO produto(
                                                    codg, 
                                                    nome, 
                                                    medida, 
                                                    qtd, 
                                                    tipo, 
                                                    peso, 
                                                    preco,
                                                    fornecedor,
                                                    obs,
                                                    criado,
                                                    ativo) 
                                                VALUES(
                                                    '$codigo',
                                                    '$nome',
                                                    '$medida',
                                                    '0',
                                                    '$tipo',
                                                    '$peso',
                                                    '$preco',
                                                    '$fornecedor',
                                                    '$obs',
                                                    '$dt_hr',
                                                    1)") or die(mysqli_error($conn));
    }
?>