<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['tk_bh'])) { 
    exit('Inválido');
}

$tk = $_POST['tk_bh'];
if (!isset($_SESSION['tokens'][$tk])) {
    exit('Token inválido');
}

$data = $_SESSION['tokens'][$tk];

if (time() - $data['time'] > 300) { // 5 min expiry
    unset($_SESSION['tokens'][$tk]);
    exit('Token expirado');
}

$id_bh = (int) $data['id'];
// uso único:
unset($_SESSION['tokens'][$tk]);

$_SESSION['id_alfa'] = $id_bh;
header('Location: ../ws_bh_func.php');
exit;
?>