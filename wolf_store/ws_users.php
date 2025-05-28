<?php
    require_once('scripts/ws_credencial.php');
    include_once('scripts/ws_logoff.php');
    require_once('conn/conn.php');
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
    <?php 
        include_once('scripts/ws_vbar.html');
        $sql = mysqli_query($conn, "SELECT id, login, nivel, cargo, nome FROM usuario WHERE ativo=1") or die(mysqli_error($conn));

    ?>
    <div class="conteudo">
        <h1>USUÁRIOS</h1>
        <div class="ws_user">
            <form name="form-us" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="POST">
                <table class="main-table" align="center" border="1">
                    <tr align="center" class="tr-cab">
                        <td class="td-cab">Código</td>
                        <td class="td-cab">Login</td>
                        <td class="td-cab">Nível</td>
                        <td class="td-cab">Cargo</td>
                        <td class="td-cab">Nome</td>
                    </tr>
                    <?php
                    if (mysqli_num_rows($sql) > 0) {
                        while($row = mysqli_fetch_assoc($sql)) { 
                            echo "
                                <tr align='left' class='tr-main'>
                                    <td>".$row['id']."</td>
                                    <td>".$row['login']."</td>
                                    <td>".$row['nivel']."</td>
                                    <td>".$row['cargo']."</td>
                                    <td>".$row['nome']."</td>
                                </tr>";
                        }
                    } else {
                        echo "Sem dados para exibição :(";
                    }
                    ?>
                </table>
            </form>
        </div>
    </div>
</body>
</html>