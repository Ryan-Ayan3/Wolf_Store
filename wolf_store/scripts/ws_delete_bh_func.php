<?php
    require_once('../conn/conn.php');
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $matr_del = $_POST['matr']; //Conversor para tipo INT. Medida de segurança
        $idalfa = intval($_POST['idalfa']);
        $tabela_del = preg_replace('/[^a-zA-Z0-9_]/', '', $_POST['tabela']); //Sanitização para permisão somente de letras, números e underline. Medida de segurança

        // Deletar bh func
        $sql_del = mysqli_query($conn,"UPDATE $tabela_del
                           SET
                            ativo='0',
                            deletado='$dt_hr'
                           WHERE
                            fk_banco_horas=$idalfa AND
                            fk_matr=$matr_del AND
                            ativo=1") or die(mysqli_error($conn));
  
        echo "ok";
    }
?>