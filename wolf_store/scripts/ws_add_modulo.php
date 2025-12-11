<?php
    require_once('../conn/conn.php');
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $nome = trim(mysqli_real_escape_string($conn,$_POST['nome']));
        $modulo = trim(mysqli_real_escape_string($conn,$_POST['modulo']));
        $ePai = trim(mysqli_real_escape_string($conn,$_POST['ePai']));
        $mark = trim(mysqli_real_escape_string($conn,$_POST['mark']));

        //PARA REMOVER ACENTUAÇÕES DE CARACTERES
        $mapa = ['á' => 'a', 'à' => 'a', 'ã' => 'a', 'â' => 'a', 'é' => 'e', 'ê' => 'e', 'í' => 'i', 'ó' => 'o', 'õ' => 'o', 'ô' => 'o', 'ú' => 'u', 'ç' => 'c', 'Á' => 'a', 'É' => 'e', 'Í' => 'i', 'Ó' => 'o', 'Ú' => 'u', 'Ç' => 'c'];

        if ($nome == '') {
            echo "CAMPO NOME VÁZIO";
            exit;
        }

        //TRANSFORMAR PARA MINÚSCULA
        $temp1 = mb_strtolower($nome, 'UTF-8');
        //REMOVER ACENTUAÇÃO COM ICONV
        $temp1 = iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $temp1);
        $sqlTemp1 = mysqli_query($conn, "SELECT nome FROM modulo WHERE ativo=1") or die(mysqli_error($conn));

        //Consulta todos os nomes de Módulos e verifica se já há algum existente
        while ($rowTemp1 = mysqli_fetch_assoc($sqlTemp1)) {
            $temp2 = mb_strtolower($rowTemp1['nome'], 'UTF-8');
            //REMOVE AS ACENTUAÇÕES DAS LETRAS
            $temp2 = strtr($temp2, $mapa);
            if ($temp1 == $temp2) {
                echo "JÁ EXISTE UM MÓDULO COM ESTE NOME";
                exit;
            }
        }
        
        if ($mark === "A2" and $modulo == 0) {
            echo "CAMPO MÓDULO ASSOCIADO OBRIGATÓRIO";
            exit;
        }

        //Se for Módulo PAI
        if ($modulo == 0) {
            //Consultar último de módulo pai
            $sqlTemp2 = mysqli_query($conn, "SELECT id FROM modulo WHERE ativo=1 AND id < 50 ORDER BY id DESC LIMIT 1") or die(mysqli_error($conn));
            $rowTemp2 = mysqli_fetch_assoc($sqlTemp2);
            $ultId = $rowTemp2['id'] + 1;
            $sql = mysqli_query($conn, "INSERT INTO modulo(id,nome,criado,ativo) VALUES($ultId,'$nome','$dt_hr', 1)") or die(mysqli_error($conn));
        //Se for Módulo Filho
        } else {
            $sql = mysqli_query($conn, "INSERT INTO modulo(nome,id_pai,criado,ativo) VALUES('$nome',$modulo,'$dt_hr', 1)") or die(mysqli_error($conn));
        }

        echo "ok";
    }
?>