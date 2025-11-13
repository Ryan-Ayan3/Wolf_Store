<?php
session_start();
require_once('../conn/conn.php');

function erro($mensagem) {
    // Função que exibe um alert e volta à página anterior
    echo "<script>alert('$mensagem'); window.history.back();</script>";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['tk_bh'])) { 
    erro('Procedimento Inválido');
}

$tk = $_POST['tk_bh'];
if (!isset($_SESSION['tokens'][$tk])) {
    erro('Token inválido');
}

$data = $_SESSION['tokens'][$tk];

if (time() - $data['time'] > 300) { // 5 min expiry
    unset($_SESSION['tokens'][$tk]);
    erro('Token expirado');
}

$id_bh = (int) $data['id'];

$sql_validador = mysqli_query($conn, "SELECT * FROM banco_horas WHERE ativo=1 AND encerrado=1 AND id=$id_bh") or die(mysqli_error($conn));
if (mysqli_num_rows($sql_validador) > 0) {
    unset($_SESSION['tokens'][$tk]);
    erro('Esse Ano BH está encerrado');
}
// uso único:
unset($_SESSION['tokens'][$tk]);

$_SESSION['id_alfa'] = $id_bh;
header('Location: ../ws_bh_func.php');
exit;
?>