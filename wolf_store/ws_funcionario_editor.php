<?php
    require_once('conn/conn.php');
    $id_edit = intval($_GET['id']); //Conversor para tipo INT. Medida de segurança
    $tabela_edit = preg_replace('/[^a-zA-Z0-9_]/', '', $_GET['tabela']); //Sanitização para permisão somente de letras, números e underline. Medida de segurança

    $sql = mysqli_query($conn, "SELECT * FROM $tabela_edit WHERE id=$id_edit") or die(mysqli_error($conn));
    $row = mysqli_fetch_assoc($sql);

    if ($row['alterado'] == NULL){
        $dataAlt = "Sem dado";
    } else {
        $dataAlt = date("H:i:s - d/m/Y", strtotime($row['alterado']));
    }
?>

<div class="div-us-edit" id="div-us-edit">
    <a href="" onclick="voltarPagina()" class="nav-link"><h1>Funcionários</a> > Edição</h1>
    <form name="form-us-edit" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="POST">
        <table class="main-table-form" id="main-table-form" align="center">
            <tr align="left">
                <td colspan="2" style="padding-bottom:20px;"><h2>Criar Funcionário</h2></td>
            </tr>
            <tr align="left" class="tr-main-form">
                <td class="td-tit" name="td-tit">Matrícula</td>
                <td class="td-tit" name="td-tit"><input type="text" class="itxt-l" name="matricula" placeholder="Número da Matrícula" value="<?php echo $row['matr'];?>" required oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 6)" maxlength="6"></input></td>
            </tr>
            <tr aligh="left" class="tr-main-form">
                <td class="td-tit" name="td-tit">Nome</td>
                <td class="td-tit" name="td-tit"><input type="text" class="itxt-l" name="nome" placeholder="Nome do funcionário" value="<?php echo $row[''];?>" required></input></td>
            </tr>
            <tr aligh="left" class="tr-main-form">
                <td class="td-tit" name="td-tit">Departamento</td>
                <td class="td-tit" name="td-tit">
                    <select name="dp">
                        <option value="0">SELECIONE DP</option>
                        <?php
                        $sql_dp = mysqli_query($conn, "SELECT id, nome FROM departamento WHERE ativo=1 ORDER BY id ASC")or die(mysqli_error($conn));
                        if (mysqli_num_rows($sql_dp) > 0) {
                            while ($row_dp = mysqli_fetch_assoc($sql_dp)) {
                                 ?>
                                 <option value="<?php echo $row_dp['id'];?>"><?php echo $row_dp['id']." - ".$row_dp['nome'];?></option>
                                 <?php
                            }
                        }
                        ?>
                    </select>
                </td>
            </tr>
            <tr aligh="left" class="tr-main-form">
                <td class="td-tit" name="td-tit">Setor</td>
                <td class="td-tit" name="td-tit">
                    <select name="setor">
                        <option value="0">SELECIONE SETOR</option>
                        <?php
                        $sql_setor = mysqli_query($conn, "SELECT id, nome FROM setor WHERE ativo=1 ORDER BY id ASC")or die(mysqli_error($conn));
                        if (mysqli_num_rows($sql_setor) > 0) {
                            while ($row_setor = mysqli_fetch_assoc($sql_setor)) {
                                 ?>
                                 <option value="<?php echo $row_setor['id'];?>"><?php echo $row_setor['id']." - ".$row_setor['nome'];?></option>
                                 <?php
                            }
                        }
                        ?>
                    </select>
                </td>
            </tr>
            <tr aligh="left" class="tr-main-form">
                <td class="td-tit" name="td-tit">Função</td>
                <td class="td-tit" name="td-tit">
                    <select name="funcao">
                        <option value="0">SELECIONE FUNÇÃO</option>
                        <?php
                        $sql_funcao = mysqli_query($conn, "SELECT id, nome FROM funcao WHERE ativo=1 ORDER BY id ASC")or die(mysqli_error($conn));
                        if (mysqli_num_rows($sql_funcao) > 0) {
                            while ($row_funcao = mysqli_fetch_assoc($sql_funcao)) {
                                 ?>
                                 <option value="<?php echo $row_funcao['id'];?>"><?php echo $row_funcao['id']." - ".$row_funcao['nome'];?></option>
                                 <?php
                            }
                        }
                        ?>
                    </select>
                </td>
            </tr>
            <tr aligh="left" class="tr-main-form">
                <td class="td-tit" name="td-tit">GRUPO</td>
                <td class="td-tit" name="td-tit">
                    <select name="grupo">
                        <option value="0">SELECIONE GRUPO</option>
                        <?php
                        $sql_grupo = mysqli_query($conn, "SELECT id, nome FROM grupo WHERE ativo=1 ORDER BY id ASC")or die(mysqli_error($conn));
                        if (mysqli_num_rows($sql_grupo) > 0) {
                            while ($row_grupo = mysqli_fetch_assoc($sql_grupo)) {
                                 ?>
                                 <option value="<?php echo $row_grupo['id'];?>"><?php echo $row_grupo['id']." - ".$row_grupo['nome'];?></option>
                                 <?php
                            }
                        }
                        ?>
                    </select>
                </td>
            </tr>
            <tr aligh="left" class="tr-main-form">
                <td class="td-tit" name="td-tit">Salário(R$)</td>
                <td class="td-tit" name="td-tit"><input type="text" class="itxt-l" name="salario" placeholder="Salário Base" required oninput="this.value = this.value.replace(/[^0-9,]/g, '').replace(/(,.*?),/g, '$1').replace(/,(\d{2}).*$/, ',$1')"></input></td>
            </tr>
            <tr aligh="left" class="tr-main-form">
                <td class="td-tit" name="td-tit">Afastado?</td>
                <td class="td-tit" name="td-tit">
                    <input type="radio" class="iradio" name="afastado" value="1" required>Sim</input>
                    <input type="radio" class="iradio" name="afastado" value="0" required>Não</input>
                </td>
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