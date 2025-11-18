<?php
    session_start();
    require_once('../conn/conn.php');
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (!isset($_POST['ids']) || count($_POST['ids']) === 0) {
            echo "<script>alert('Nenhum item selecionado!'); window.history.back();</script>";
            exit;
        }
        $id_primary = $_SESSION['id_naveg'];    
        $ids = $_POST['ids'];

        // Exemplo: inserir todos os IDs em outra tabela
        foreach ($ids as $id) {
            $id = (int)$id;
            $mes = 0;
            $sql_func = mysqli_query($conn, "SELECT matr FROM funcionario WHERE ativo=1 AND id=$id") or die(mysqli_error($conn));
            $row_func = mysqli_fetch_assoc($sql_func);
            $matr = $row_func['matr'];
            while ($mes >= 0 AND $mes <= 12) {
                $sql = "INSERT INTO banco_horas_func (fk_banco_horas, fk_matr, mes, tipo_saldo, criado, ativo) VALUES ('$id_primary','$matr','$mes','0','$dt_hr','1')";
                mysqli_query($conn, $sql) or die(mysqli_error($conn));
                $mes++;
            }
            
        }

        // Limpa a sessão após o uso
        unset($_SESSION['id_naveg']);
        unset($_SESSION['dest_naveg']);

        echo "<script>alert('Registros inseridos com sucesso!'); window.location.href='../ws_bh.php';</script>";
        exit;

    } else {
        unset($_SESSION['id_naveg']);
        unset($_SESSION['dest_naveg']);
        echo "<script>alert('Não foi possível realizar a operação'); window.history.back();</script>";
        exit;
    }
    
?>