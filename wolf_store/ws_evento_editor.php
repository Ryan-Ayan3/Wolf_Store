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
    <ul class="breadcrumb">
        <li><a href="" onclick="voltarPagina()"><span class="icon-start"></span>Eventos</a></li>
        <li><a href="" onclick="voltarPagina()"><span></span>Edição</a></li>
    </ul>
    <form name="form-us-edit" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="POST">
        <table class="main-table-form" id="main-table-form" align="center">
            <tr align="left">
                <td colspan="2" style="padding-bottom:20px;"><h2>Editar Evento</h2></td>
            </tr>
            <tr align="left" class="tr-main-form">
                <td class="td-tit" name="td-tit">Nome</td>
                <td class="td-tit" name="td-tit"><input type="text" class="itxt-l" name="nome" required value="<?php echo $row['nome'];?>"></input></td>
            </tr>
            <tr aligh="left" class="tr-main-form">
                <td class="td-tit" name="td-tit">Tipo de Saldo</td>
                <td class="td-tit" name="td-tit">
                    <input type="radio" class="iradio" name="tipo_saldo" value="1" required <?php if($row['tipo_saldo'] == 1){ echo "checked";}?>>Positivo</input>
                    <input type="radio" class="iradio" name="tipo_saldo" value="2" required <?php if($row['tipo_saldo'] == 2){ echo "checked";}?>>Negativo</input>
                </td>
            </tr>
            <tr aligh="left" class="tr-main-form">
                <td class="td-tit" name="td-tit">Função</td>
                <td class="td-tit" name="td-tit">
                    <input type="radio" class="iradio" name="funcao" value="1" required <?php if($row['funcao'] == 1){ echo "checked";}?>>Folha</input>
                    <input type="radio" class="iradio" name="funcao" value="2" required <?php if($row['funcao'] == 2){ echo "checked";}?>>Banco de Horas</input>
                    <input type="radio" class="iradio" name="funcao" value="3" required <?php if($row['funcao'] == 3){ echo "checked";}?>>Folha e BH</input>
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