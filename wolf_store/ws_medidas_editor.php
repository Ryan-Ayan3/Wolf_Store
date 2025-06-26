<?php
    require_once('conn/conn.php');
    $id_edit = intval($_GET['id']); //Conversor para tipo INT. Medida de segurança
    $tabela_edit = preg_replace('/[^a-zA-Z0-9_]/', '', $_GET['tabela']); //Sanitização para permisão somente de letras, números e underline. Medida de segurança

    $sql = mysqli_query($conn, "SELECT * FROM $tabela_edit WHERE id=$id_edit") or die(mysqli_error($conn));
    $row = mysqli_fetch_assoc($sql);

    if($row['tipoValor'] == 1) {
        $tipoValor = "Inteiro";
    } elseif($row['tipoValor'] == 2) {
        $tipoValor = "Decimal";
    } else {
        $tipoValor = "Sem Dado";   
    }

    if ($row['alterado'] == NULL){
        $dataAlt = "Sem dado";
    } else {
        $dataAlt = date("H:i:s - d/m/Y", strtotime($row['alterado']));
    }
?>

<div class="div-us-edit" id="div-us-edit">
    <a href="" onclick="voltarPagina()" class="nav-link"><h1>Unidades de Medidas</a> > Edição</h1>
    <form name="form-us-edit" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="POST">
        <table class="main-table-form" id="main-table-form" align="center">
            <tr align="left">
                <td colspan="2" style="padding-bottom:20px;"><h2>Editar Unidades de Medidas</h2></td>
            </tr>
            <tr align="left" class="tr-main-form">
                <td class="td-tit" name="td-tit">Nome</td>
                <td class="td-tit" name="td-tit"><input type="text" class="itxt-l" name="nome" required value="<?php echo $row['nome'];?>"></input></td>
            </tr>
            <tr align="left" class="tr-main-form">
                <td class="td-tit" name="td-tit">Tipo Valor</td>
                <td class="td-tit" name="td-tit">
                    <select name="tipoValor">
                        <option value="<?php echo $row['tipoValor'];?>"><?php echo $tipoValor;?></option>
                        <option>SELECIONE TIPO</option>
                        <option value="1">OP 1 - Inteiro</option>
                        <option value="2">OP 2 - Decimal</option>
                    </select>
                </td>
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