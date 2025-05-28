<?php
    require_once('ws_credencial.php');
    include_once('ws_logoff.php');
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
    <?php include_once('conn/conn.php');?>
</head>
<style>
    body 
    {
        background-image: url('background1.jpg');
        background-repeat: no-repeat;
        background-size: cover;
        overflow: hidden;
    }
</style>
<body>
    <?php 
        if (isset($_POST['sub-create'])) {
            $nome = trim(mysqli_real_escape_string($conn,$_POST['nome']));
            $cargo = trim(mysqli_real_escape_string($conn,$_POST['cargo']));
            $login = trim(mysqli_real_escape_string($conn,strtolower($_POST['login'])));
            $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);
            
            $sql = mysqli_query($conn, "SELECT login FROM usuario WHERE login='$login'");
            $row = mysqli_fetch_assoc($sql);

            if($login == NULL) {
                ?>
                <script>
                    alert('Este login está indisponível, tente novamente');
                </script>
                <?php
            } else {
                $sql_insert = mysqli_query($conn,"INSERT INTO usuario(login, senha, cargo, nome, criado, ativo) VALUES ('$login', '$senha', '$cargo', '$nome', '$dt_hr', '1');");
                ?> 
                    <script>document.location.href="index.php";</script>
                <?php                
            }
        }
    ?>
    <div class="in-main-struc" name="in-main-struc">
        <form id="form_us" name="form-us" action="<?php echo $_SERVER['PHP_SELF'] ;?>" method="POST">
            <table class="main-table" align="center">
                <tr align="left" class="tr-main" name="tr-main">
                    <td colspan="2" style="padding-bottom:20px;">Cadastro</td>
                </tr>
                <tr align="left" class="tr-main" name="tr-main">
                    <td class="td-tit" name="td-tit">Nome Completo:
                        <input type="text" class="itxt-l" name="nome" placeholder="Nome da pessoa" required></input>
                    </td>
                    <td class="td-tit" name="td-tit">Cargo:
                        <input type="text" class="itxt-r" name="cargo" placeholder="Cargo exercido" required>
                    </td>
                </tr>
                <tr align="left" class="tr-main" name="tr-main">
                    <td class="td-tit" name="td-tit" style="padding-top:20px;">Login:
                        <input type="text" class="itxt-l" name="login" placeholder="Login de usuário" required></input>
                    </td>
                    <td class="td-tit" name="td-tit" style="padding-top:20px;">Senha:
                        <input type="password" class="itxt-r" name="senha" placeholder="Senha do usuário" required></input>
                    </td>
                </tr>
                <tr align="center" class="tr-main" name="tr-main">
                    <td colspan="2"><input type="submit" class="sub-create" name="sub-create" value="Enviar"></input></td>
                </tr>
            </table>
        </form>
    </div>
</body>
</html>