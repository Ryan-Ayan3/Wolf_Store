<?php 
    include_once('ws_credencial.php');
    include_once('ws_logoff.php');
    include_once('conn/conn.php');
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="author" content="Rian I. Silva" />
    <title>Wolf Store</title>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="icon" type="image/x-icon" href="imgs/wolf_store_logo.jpg">
</head>
<body>
    <script>
        function togglevbar(event) {
            event.preventDefault();
            var item = event.target.closest('.submenu');
            item.classList.toggle('open');
        }
    </script>
    <div class="vbar">
        <h2>Menu</h2>
        <ul>
            <li><a href="#">Início</a></li>
            <li class="submenu">
                <a href="#" onclick="togglevbar(event)">Comercial ▾</a>
                <ul class="op-com">
                    <li><a href="#">Cliente</a></li>
                    <li><a href="#">Venda</a></li>
                    <li><a href="#">Comissão</a></li>
                </ul>
            </li>
            <li><a href="#">Armazém</a></li>
            <li><a href="#">Configurações</a></li>
            <li><form method="POST"><input type="submit" class="sair" name="sair" value="Sair"></form></li>
        </ul>
    </div>
    <div class="conteudo">
        <h1>Bem-vindo</h1>
        <p>Conteúdo principal vai aqui.</p>
    </div>
</body>
</html>