<?php 
	date_default_timezone_set('America/Sao_Paulo');
	$dt_hr = date('Y/m/d H:i:s');

    $servidor = $_SERVER['HTTP_HOST'];
    if ($servidor == null) 
    {
		$servidor = 'localhost';
    }
	$banco = "wolf_store";
	$user = "root";
	$senha = "";
	$conn = mysqli_connect($servidor, $user, $senha, $banco) or die(mysqli_connect_errno()); 
	if (!mysqli_set_charset($conn,"utf8"))
    {
		echo 'Erro na configuração UTF-8';
		exit;
	};
?>