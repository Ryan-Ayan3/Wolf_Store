<?php
    session_start();
    require_once('../conn/conn.php');
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (!isset($_POST['ids']) || count($_POST['ids']) === 0) {
            echo "<script>alert('Nenhum item selecionado!'); window.history.back();</script>";
            exit;
        }
        $id_primary = $_SESSION['id_nivel'];
        $ids = $_POST['ids'];

        
        
        foreach ($ids as $id => $procedimento) {
            $id = (int)$id;
            
            // Consulta para coletar Permissão
            $sql_perm = mysqli_query($conn,"SELECT
                                                mp.id AS idPerm, m.nome AS mNome, mp.ativo AS ativoPerm
                                            FROM
                                                modulo_permissao mp
                                            JOIN nivel n ON mp.fk_nivel = n.id
                                            JOIN modulo m ON mp.fk_modulo = m.id
                                            WHERE
                                                mp.fk_nivel = $id_primary AND
                                                mp.fk_modulo = $id") or die(mysqli_error($conn));
            $row_perm = mysqli_fetch_assoc($sql_perm);
           
            // Procedimento para ativar Permissão
            if ($procedimento == 1) {
                // Caso não esteja desativado ou ativado criará um registro novo
                if (mysqli_num_rows($sql_perm) == 0) {
                    $sql3 = mysqli_query($conn,"INSERT INTO modulo_permissao(fk_modulo,fk_nivel,criado,ativo) VALUES ($id,$id_primary,'$dt_hr',1);");
                // Verifica se a permissão está desativada para reativar no sistema
                } elseif (!empty($row_perm['idPerm'])) {
                    $idPerm = $row_perm['idPerm'];
                    $sql2 = mysqli_query($conn,"UPDATE modulo_permissao SET ativo=1, alterado='$dt_hr' WHERE id=$idPerm");
                } else {
                    echo "<script>alert('Erro 1512, tente novamente se o erro persistir contate a TI'); window.history.back();</script>";
                    exit;
                }
                
            // Procedimento para desativar Permissão
            } else {
                if (!empty($row_perm['ativoPerm'])) {
                    $idPerm = $row_perm['idPerm'];
                    // Verifica se a permissão está ativada para desativar no sistema se existir apenas
                    $sql2 = mysqli_query($conn,"UPDATE modulo_permissao SET ativo=0, deletado='$dt_hr' WHERE id=$idPerm");
                }
            }
        }
        // Limpa a sessão após o uso
        unset($_SESSION['id_nivel']);
        echo "<script>alert('Permissões alteradas com sucesso!'); window.location.href='../ws_nivel.php';</script>";
        exit;

    } else {
        unset($_SESSION['id_nivel']);
        echo "<script>alert('Não foi possível realizar a operação'); window.history.back();</script>";
        exit;
    }
    
?>