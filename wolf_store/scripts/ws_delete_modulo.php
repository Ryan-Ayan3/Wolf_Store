<?php
    require_once('../conn/conn.php');
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $id_del = intval($_POST['id']); //Conversor para tipo INT. Medida de segurança
        $tabela_del = preg_replace('/[^a-zA-Z0-9_]/', '', $_POST['tabela']); //Sanitização para permisão somente de letras, números e underline. Medida de segurança

        $sqlTemp = mysqli_query($conn, "SELECT 1
                                         FROM
                                            modulo m
                                         LEFT JOIN modulo_permissao mp ON mp.fk_modulo = m.id
                                         WHERE
                                            m.id =$id_del") or die(mysqli_error($conn));
        if (mysqli_num_rows($sqlTemp) > 0) {
            echo "MÓDULO JÁ POSSUE PERMISSÕES ATIVAS OU INATIVAS";
            exit;
        }
        
        $sql_dell = mysqli_query($conn, "UPDATE $tabela_del SET ativo=0,deletado='$dt_hr' WHERE id=$id_del") or die(mysqli_error($conn));

        echo "ok";
    }
?>