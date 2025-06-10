<?php
    require_once('conn/conn.php');
    $id_edit = intval($_GET['id']); //Conversor para tipo INT. Medida de segurança
    $tabela_edit = preg_replace('/[^a-zA-Z0-9_]/', '', $_GET['tabela']); //Sanitização para permisão somente de letras, números e underline. Medida de segurança

    $sql = mysqli_query($conn, "SELECT * FROM $tabela_edit WHERE id=$id_edit") or die(mysqli_error($conn));
    $row = mysqli_fetch_assoc($sql);
    $temp = $row['nivel'];
    $sql2 = mysqli_query($conn, "SELECT nome, nivel FROM nivel_ac WHERE nivel=$temp") or die(mysqli_error($conn));
    $row2 = mysqli_fetch_assoc($sql2);

    if ($row['alterado'] == NULL){
        $dataAlt = "Sem dado";
    } else {
        $dataAlt = date("H:i:s - d/m/Y", strtotime($row['alterado']));
    }
?>

<div class="div-us-edit">
    <a href="" onclick="voltarPagina()" class="nav-link"><h1>USUÁRIOS</a> > Edição</h1>
    <form name="form-us-edit" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="POST">
        <table class="main-table-form" align="center">
            <tr align="left">
                <td colspan="2" style="padding-bottom:20px;"><h2>Editar Usuário</h2></td>
            </tr>
            <tr align="left" class="tr-main-form">
                <td class="td-tit" name="td-tit">Login</td>
                <td class="td-tit" name="td-tit"><input type="text" class="itxt-l" name="login" required value="<?php echo $row['login'];?>"></input></td>
            </tr>
            <tr align="left" class="tr-main-form">
                <td class="td-tit" name="td-tit">Definir Senha</td>
                <td class="td-tit" name="td-tit"><input type="text" class="itxt-l" name="nova_senha"></input></td>
            </tr>
            <tr align="left" class="tr-main-form">
                <td class="td-tit" name="td-tit">Nível</td>
                <td class="td-tit" name="td-tit">
                    <select name="nivel">
                        <option value="<?php echo $row['nivel'];?>" selected><?php echo $row2['nome']; ?></option>
                        <option>SELECIONE NÍVEL</option>
                        <?php 
                            $sql_nivel = mysqli_query($conn, "SELECT nome, nivel FROM nivel_ac WHERE ativo=1") or die(mysqli_error($conn));
                            $numero = 1;
                            if (mysqli_num_rows($sql_nivel) > 0) {
                                while($row_nivel = mysqli_fetch_assoc($sql_nivel)) {
                                    ?>
                                    <option value="<?php echo $row_nivel['nivel'];?>"><?php echo $numero." - ".$row_nivel['nome']; ?></option>
                                    <?php
                                    $numero++;
                                }
                            }
                        ?>
                    </select>
                </td>
            </tr>
            <tr align="left" class="tr-main-form">
                <td class="td-tit" name="td-tit">Email</td>
                <td class="td-tit" name="td-tit"><input type="text" class="itxt-l" name="email" required value="<?php echo $row['email'];?>"></input></td>
            </tr>
            <tr align="left" class="tr-main-form">
                <td class="td-tit" name="td-tit">Cargo</td>
                <td class="td-tit" name="td-tit"><input type="text" class="itxt-l" name="cargo" required value="<?php echo $row['cargo'];?>"></input></td>
            </tr>
            <tr align="left" class="tr-main-form">
                <td class="td-tit" name="td-tit">Nome</td>
                <td class="td-tit" name="td-tit"><input type="text" class="itxt-l" name="nome" required value="<?php echo $row['nome'];?>"></input></td>
            </tr>
            <tr align="left" class="tr-main-form">
                <td class="td-tit" name="td-tit">Alterado</td>
                <td class="td-tit" name="td-tit"><input type="text" class="itxt-l" disabled value="<?php echo $dataAlt;?>"></input></td>
            </tr>
            <tr align="center">
                <td colspan="2">
                    <input onclick="editRegistro('<?php echo $id_edit;?>','<?php echo $tabela_edit;?>')" type="button" class="sub-create" name="sub-create" value="Enviar"></input>
                    <input onclick="voltarPagina()" type="button" class="sub-back" name="sub-back" value="Voltar"></input>
                </td>
            </tr>
        </table>
    </form>
</div>