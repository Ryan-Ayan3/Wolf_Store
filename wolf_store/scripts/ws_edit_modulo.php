<?php
    require_once('../conn/conn.php');
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $id_edit2 = intval($_POST['id']); //Conversor para tipo INT. Medida de segurança
        $tabela_edit2 = preg_replace('/[^a-zA-Z0-9_]/', '', $_POST['tabela']); //Sanitização para permisão somente de letras, números e underline. Medida de segurança
        $nome = trim(mysqli_real_escape_string($conn,$_POST['nome']));
        $modulo = trim(mysqli_real_escape_string($conn,$_POST['modulo']));
        $ePai = trim(mysqli_real_escape_string($conn,$_POST['ePai']));
        $mark = trim(mysqli_real_escape_string($conn,$_POST['mark']));

        $alterar_f = $dt_hr;

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
        
        if ($mark === "A2" AND $modulo == 0) {
            echo "CAMPO MÓDULO ASSOCIADO OBRIGATÓRIO";
            exit;
        }
        
        // ATUALIZAR COMO MÓDULO PAI
        if ($modulo == 0) {
            $sql3 = mysqli_query($conn,"UPDATE $tabela_edit2 
                                            SET 
                                                nome='$nome',
                                                id_pai=NULL,
                                                alterado='$alterar_f' 
                                            WHERE id=$id_edit2") or die(mysqli_error($conn));
        // ATUALIZAR COMO MÓDULO FILHO
        } else {
            $sql3 = mysqli_query($conn,"UPDATE $tabela_edit2 
                                            SET 
                                                nome='$nome',
                                                id_pai=$modulo,
                                                alterado='$alterar_f' 
                                            WHERE id=$id_edit2") or die(mysqli_error($conn));
        }
        
        echo "ok";
    }
?>