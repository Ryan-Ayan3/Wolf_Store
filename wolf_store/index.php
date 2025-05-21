<?php session_start(); ?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="author" content="Rian I. Silva" />
    <title>Wolf Store</title>
    <link rel="stylesheet" href="css/styles.css"><!-- Conectar uma folha css em outra pasta -->
    <link rel="icon" type="image/x-icon" href="imgs/wolf_store_logo.jpg"><!-- Adicionar um icon no guia da página -->
    <?php include_once('conn/conn.php');?>
</head>
<style>
    body 
    {
      background-image: url('background1.jpg');
    }
</style>
<body>

    <?php
        if (isset($_POST['submit-log'])) 
        {
            $login = trim(addslashes(strtolower($_POST['usuario'])));
            $senha = addslashes($_POST['senha']);

            $sql = mysqli_query($conn,"SELECT login, senha FROM usuario");
            $result = mysqli_fetch_array($sql);

            if (password_verify($senha, $result['senha'])) 
            {
                ?>
                <script>
				    document.location.href="portal_acessos.php";
			    </script>
                <?php
                $_SESSION["conectado"] = $login;
            } else 
            {
                ?>
                <script>
                    alert('Usuário ou Senha incorreto');
			    </script>
                <?php
            }
        }

    ?>
    <!-- Comentário HTML -->
    <div name="in-main-struc" class="in-main-struc">
        <div class ="titu">
            <legend>Logar no sistema</legend>
        </div>
        <form id="form_log" name="form-log" action="<?php echo $_SERVER['PHP_SELF'] ;?>" method="POST">
            <table class="main-log" border="0">
                <tr class="tit-log">
                    <td class="icon" align="right"><img src="icon/usr1.png" height="30px" width="30px"></td>
                    <td><input type="text" class="itxt-log" name="usuario" placeholder="Usuário" required></td>
                </tr>
                <tr class="tit-log">
                    <td class="icon" align="right"><img src="icon/pword1.png" height="30px" width="30px"></td>
                    <td><input type="password" class="itxt-log" name="senha" placeholder="Senha" required></td>
                </tr class="tit-log">
                <tr align="center">
                    <td colspan="2"><input type="submit" class="submit-log" name="submit-log" value="ACESSAR"></td>
                </tr>
            </table>
        </form>
    </div>
</body>
</html>