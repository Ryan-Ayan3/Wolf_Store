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
        <h2><a href="ws_home.php" class="menu"><img src="imgs/wolf_store_logo.jpg" height="30px" width="30px">Wolf Store</a></h2>
        <ul>
            <li class="submenu">
                <a href="" onclick="togglevbar(event)" class="legenda"><img src="icons/add1.png" height="22px" width="22px">Aquisições</a>
                <ul class="op-com">
                    <li><a href="#">Produto</a></li>
                    <li><a href="#">Fornecedor</a></li>
                    <li><a href="#">Aquisição de Produto</a></li>
                </ul>
            </li>
            <li class="submenu">
                <a href="#" onclick="togglevbar(event)" class="legenda"><img src="icons/estoque1.png" height="22px" width="22px">Estoque</a>
                <ul class="op-com">
                    <li><a href="#">Posição de Estoque</a></li>
                    <li><a href="#">Analisar Estoque</a></li>
                    <li><a href="#">Inventário</a></li>
                    <li><a href="#">Entrada Livre</a></li>
                    <li><a href="#">Saída Livre</a></li>
                    <li><a href="#">Posição de Estoque</a></li>
                    <li><a href="#">Analisar Estoque</a></li>
                    <li><a href="#">Inventário</a></li>
                    <li><a href="#">Entrada Livre</a></li>
                    <li><a href="#">Saída Livre</a></li>
                    <li><a href="#">Posição de Estoque</a></li>
                    <li><a href="#">Analisar Estoque</a></li>
                    <li><a href="#">Inventário</a></li>
                    <li><a href="#">Entrada Livre</a></li>
                    <li><a href="#">Saída Livre</a></li>
                </ul>
            </li>
            <li class="submenu">
                <a href="#" onclick="togglevbar(event)" class="legenda"><img src="icons/moeda1.png" height="22px" width="22px">Comercial</a>
                <ul class="op-com">
                    <li><a href="#">Cliente</a></li>
                    <li><a href="#">Venda</a></li>
                </ul>
            </li>
            <li class="submenu">
                <a href="#" onclick="togglevbar(event)" class="legenda"><img src="icons/config1.png" height="22px" width="22px">Sistema</a>
                <ul class="op-com">
                    <li><a href="#">Usuário</a></li>
                    <li><a href="#">Tipos de Movimentação</a></li>
                </ul>
            </li>
            <li class="submenu"><form method="POST"><input type="submit" class="sair" name="sair" value="Sair"></form></li>
        </ul>
    </div>
    <div class="bg-conteudo">

    </div>
    <div class="conteudo">
        <h1>Bem-vindo à:</h1>
        <!--<img class="logo-bg" src="imgs/wolf_store.jpg"></img> -->
    </div>
</body>
</html>