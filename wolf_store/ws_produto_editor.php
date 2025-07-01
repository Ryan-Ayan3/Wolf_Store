<?php 
    require_once('conn/conn.php');
    $id_edit = intval($_GET['id']); //Conversor para tipo INT. Medida de segurança
    $tabela_edit = preg_replace('/[^a-zA-Z0-9_]/', '', $_GET['tabela']); //Sanitização para permisão somente de letras, números e underline. Medida de segurança

    $sql = mysqli_query($conn, "SELECT * FROM $tabela_edit WHERE id=$id_edit") or die(mysqli_error($conn));
    $row = mysqli_fetch_assoc($sql);
    $temp1 = $row['medida'];
    $temp2 = $row['tipo'];
    if ($row['fornecedor'] > 0) {
        $temp3 = $row['fornecedor'];
    } else {
        $temp3 = 0;
    }

    $sql2 = mysqli_query($conn, "SELECT * FROM unidade_medida WHERE id=$temp1") or die(mysqli_error($conn));
    $row2 = mysqli_fetch_assoc($sql2);
    
    $sql3 = mysqli_query($conn, "SELECT * FROM tipo_produto WHERE id=$temp2") or die(mysqli_error($conn));
    $row3 = mysqli_fetch_assoc($sql3);

    $sql4 = mysqli_query($conn, "SELECT id, nome FROM pessoa WHERE id=$temp3") or die(mysqli_error($conn));
    $row4 = mysqli_fetch_assoc($sql4);

    if ($row['alterado'] == NULL){
        $dataAlt = "Sem dado";
    } else {
        $dataAlt = date("H:i:s - d/m/Y", strtotime($row['alterado']));
    }
?>
<div class="div-us-edit" id="div-us-edit">
    <a href="" onclick="voltarPagina()" class="nav-link"><h1>Produtos</a> > Editar</h1>
    <form name="form-us-edit" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="POST" onkeydown="return event.key != 'Enter';">
        <table class="main-table-form" id="main-table-form" align="center">
            <tr align="left">
                <td colspan="2" style="padding-bottom:20px;"><h2>Editar Produto</h2></td>
            </tr>
            <tr align="left" class="tr-main-form">
                <td class="td-tit" name="td-tit">Código</td>
                <td class="td-tit" name="td-tit"><input type="text" class="itxt-l" name="codigo" value="<?php echo $row['codg'];?>"></input></td>
            </tr>
            <tr align="left" class="tr-main-form">
                <td class="td-tit" name="td-tit">Nome</td>
                <td class="td-tit" name="td-tit"><input type="text" class="itxt-l" name="nome" value="<?php echo $row['nome'];?>"></input></td>
            </tr>
            <tr align="left" class="tr-main-form">
                <td class="td-tit" name="td-tit">Unidade de Medida</td>
                <td class="td-tit" name="td-tit">
                    <select name="medida">
                        <option value="<?php echo $row2['id'];?>"><?php echo $row2['nome'];?></option>
                        <?php
                        $sql_medida = mysqli_query($conn,"SELECT id, nome FROM unidade_medida WHERE ativo=1") or die(mysqli_error($conn));
                        if (mysqli_num_rows($sql_medida) > 0) {
                            while ($row_medida = mysqli_fetch_assoc($sql_medida)) {
                                ?>
                                <option value="<?php echo $row_medida['id'];?>"><?php echo $row_medida['nome'];?></option>
                                <?php
                            }
                        }
                        ?>
                    </select>
                </td>
            </tr>
            <tr align="left" class="tr-main-form">
                <td class="td-tit" name="td-tit">Tipo de Produto</td>
                <td class="td-tit" name="td-tit">
                    <select name="tipo">
                        <option value="<?php echo $row3['id'];?>"><?php echo $row3['nome'];?></option>
                        <?php
                        $sql_tipo = mysqli_query($conn,"SELECT id, nome FROM tipo_produto WHERE ativo=1") or die(mysqli_error($conn));
                        if (mysqli_num_rows($sql_tipo) > 0) {
                            while ($row_tipo = mysqli_fetch_assoc($sql_tipo)) {
                                ?>
                                <option value="<?php echo $row_tipo['id'];?>"><?php echo $row_tipo['nome'];?></option>
                                <?php
                            }
                        }
                        ?>
                    </select>
                </td>
            </tr>
            <tr align="left" class="tr-main-form">
                <td class="td-tit" name="td-tit">Peso por Produto(KG)</td>
                <td class="td-tit" name="td-tit"><input type="text" class="itxt-l" name="peso" value="<?php echo $row['peso'];?>"></input></td>
            </tr>
            <tr align="left" class="tr-main-form">
                <td class="td-tit" name="td-tit">Preço</td>
                <td class="td-tit" name="td-tit"><input type="number" step="0.01" class="itxt-l" name="preco" value="<?php echo $row['preco'];?>"></input></td>
            </tr>
            <tr align="left" class="tr-main-form">
                <td class="td-tit" name="td-tit">Vincular Fornecedor</td>
                <td class="td-tit" name="td-tit">
                    <input type="text" class="itxt-l" name="fornecedor" id="pesquisador" autocomplete="off" value="<?php echo $row4['nome'];?>" ></input>
                    <input type="hidden" id="fornecedor_in" name="fornecedor_in" value="<?php echo $row4['id'];?>"></input></td>
            </tr>
            <tr align="left" class="tr-main-form">
                <td class="td-tit" name="td-tit"><td><div class="busca" id="busca"></div></td>
            </tr>
            <tr align="left" class="tr-main-form">
                <td class="td-tit" name="td-tit">Observação</td>
                <td class="td-tit" name="td-tit"><input type="text" class="itxt-l" name="obs" value="<?php echo $row['obs'];?>"></input></td>
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