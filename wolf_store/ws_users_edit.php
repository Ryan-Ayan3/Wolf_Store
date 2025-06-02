<?php
    require_once('conn/conn.php');
    $nivel = "texto";
    /*$sql_insert = mysqli_query($conn,"INSERT INTO usuario(login, senha, cargo, nome, criado, ativo) VALUES ('$login', '$senha', '$cargo', '$nome', '$dt_hr', '1');"); */
    $id_edit = intval($_GET['id']); //Conversor para tipo INT. Medida de segurança
    $tabela_edit = preg_replace('/[^a-zA-Z0-9_]/', '', $_GET['tabela']); //Sanitização para permisão somente de letras, números e underline. Medida de segurança
    $sql = mysqli_query($conn, "SELECT * FROM $tabela_edit WHERE id=$id_edit") or die(mysqli_error($conn));
    $sql2 = mysqli_query($conn, "SELECT nome, nivel FROM nivel_ac WHERE ativo=1") or die(mysqli_error($conn));
    $row = mysqli_fetch_assoc($sql);
    
    if($row['nivel'] == 1) {
        $nivel = "Admin";
    } elseif($row['nivel'] == 2) {
        $nivel = "Estoque";
    } elseif($row['nivel'] == 3) {
        $nivel = "Aquisitor";
    } elseif($row['nivel'] == 4) {
        $nivel = "Comercial";
    } elseif($row['nivel'] == 5) {
        $nivel = "Básico";
    }

    $senha_at = $row['senha'];
?>
<div class="div-us-edit" id="editInfor">
    <a href="" onclick="votarPagina()"><h1>USUÁRIOS</a> > Edição</h1>
    <form name="form-us-edit" action="<?php echo $_SERVER['PHP_SELF'] ;?>" method="POST">
        <table class="main-table-edit" align="center">
            <tr align="left">
                <td colspan="2" style="padding-bottom:20px;">Edição</td>
            </tr>
            <tr align="left" class="tr-main-edit">
                <td class="td-tit" name="td-tit">Login</td>
                <td class="td-tit" name="td-tit"><input type="text" class="itxt-l" name="login" required value="<?php echo $row['login'];?>"></input></td>
            </tr>
            <tr align="left" class="tr-main-edit">
                <td class="td-tit" name="td-tit">Definir Senha</td>
                <td class="td-tit" name="td-tit"><input type="text" class="itxt-l" name="nova_senha"></input></td>
            </tr>
            <tr align="left" class="tr-main-edit">
                <td class="td-tit" name="td-tit">Nível</td>
                <td class="td-tit" name="td-tit">
                    <select name="nível">
                        <option value="<?php echo $row['nivel'];?>" selected><?php echo $nivel; ?></option>
                        <?php 
                            if (mysqli_num_rows($sql2) > 0) {
                                while($row2 = mysqli_fetch_assoc($sql2)) {
                                    ?>
                                    <option value="<?php echo $row2['nivel'];?>"><?php echo $row2['nome']; ?></option>
                                    <?php
                                }
                            }
                        ?>
                    </select>
                </td>
            </tr>
            <tr align="left" class="tr-main-edit">
                <td class="td-tit" name="td-tit">Email</td>
                <td class="td-tit" name="td-tit"><input type="text" class="itxt-l" name="email" required value="<?php echo $row['email'];?>"></input></td>
            </tr>
            <tr align="left" class="tr-main-edit">
                <td class="td-tit" name="td-tit">Cargo</td>
                <td class="td-tit" name="td-tit"><input type="text" class="itxt-l" name="cargo" required value="<?php echo $row['cargo'];?>"></input></td>
            </tr>
            <tr align="left" class="tr-main-edit">
                <td class="td-tit" name="td-tit">Nome</td>
                <td class="td-tit" name="td-tit"><input type="text" class="itxt-l" name="nome" required value="<?php echo $row['nome'];?>"></input></td>
            </tr>
            <tr align="left" class="tr-main-edit">
                <td class="td-tit" name="td-tit">Alterado</td>
                <td class="td-tit" name="td-tit"><input type="text" class="itxt-l" disabled value="<?php echo $row['alterado'];?>"></input></td>
            </tr>
            <tr align="center" class="tr-main-edit">
                <td colspan="2">
                    <input type="submit" class="sub-create" name="sub-create" value="Enviar"></input>
                    <input onclick="voltarPagina()" type="button" class="sub-create" name="sub-create" value="Voltar"></input>
                </td>
            </tr>
        </table>
    </form>
</div>