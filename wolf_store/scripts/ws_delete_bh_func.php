<?php
    require_once('../conn/conn.php');
    include_once('ws_time.php');
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $id_del = intval($_POST['id']); //Conversor para tipo INT. Medida de segurança
        $idalfa = intval($_POST['idalfa']);
        $tabela_del = preg_replace('/[^a-zA-Z0-9_]/', '', $_POST['tabela']); //Sanitização para permisão somente de letras, números e underline. Medida de segurança

        // Deletar bh func
        $sql3 = mysqli_query($conn,"UPDATE $tabela_del SET ativo=0,deletado='$dt_hr' WHERE ativo=1 AND fk_banco_horas=$idalfa") or die(mysqli_error($conn));

        // Deletar detalhe
        $sql3 = mysqli_query($conn,"UPDATE  SET ativo=0,deletado='$dt_hr' WHERE id=$id_del") or die(mysqli_error($conn));
  
        echo "ok";
      
    }
?>