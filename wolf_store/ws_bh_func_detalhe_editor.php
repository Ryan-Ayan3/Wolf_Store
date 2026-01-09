<?php
    require_once('conn/conn.php');
    $id_edit = intval($_GET['id']); //Conversor para tipo INT. Medida de segurança
    $idf = intval($_GET['idf']);
    $tabela_edit = preg_replace('/[^a-zA-Z0-9_]/', '', $_GET['tabela']); //Sanitização para permisão somente de letras, números e underline. Medida de segurança

    $sql = mysqli_query($conn, "SELECT * FROM $tabela_edit WHERE id=$id_edit") or die(mysqli_error($conn));
    $row = mysqli_fetch_assoc($sql);
    $temp1 = $row['fk_evento'];
    
    $sql_evento = mysqli_query($conn, "SELECT id,nome FROM evento WHERE ativo=1 AND id=$temp1 AND (funcao=2 OR funcao=3)") or die(mysqli_error($conn));
    $row_evento = mysqli_fetch_assoc($sql_evento);

    if ($row['alterado'] == NULL){
        $dataAlt = "Sem dado";
    } else {
        $dataAlt = date("H:i:s - d/m/Y", strtotime($row['alterado']));
    }
?>

<div class="div-us-edit" id="div-us-edit">
    <ul class="breadcrumb">
        <li><a href="ws_bh.php"><span class="icon-start"></span>Bancos de Horas</a></li>
        <li><a href="ws_bh_func.php"><span></span>Funcionários</a></li>
        <li><a href="#" onclick="voltarPagina()"><span></span>Detalhe</a></li>
        <li><a href="#"><span></span>Edição</a></li>
    </ul>
    <form name="form-us-edit" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="POST">
        <table class="main-table-form" id="main-table-form" align="center">
            <tr align="left">
                <td colspan="2" style="padding-bottom:20px;"><h2>Editar Detalhe</h2></td>
            </tr>
            <tr aligh="left" class="tr-main-form">
                <input type="hidden" name="idf" value="<?= $idf ?>">
                <td class="td-tit" name="td-tit">Evento</td>
                <td class="td-tit" name="td-tit">
                    <select name="evento">
                        <option value='<?= $row_evento['id'];?>'><?= $row_evento['nome'];?></option>
                        <?php
                        $sql_ev = mysqli_query($conn, "SELECT id, nome FROM evento WHERE ativo=1 AND (funcao=2 OR funcao=3) AND NOT id=$temp1 ORDER BY id ASC")or die(mysqli_error($conn));
                        if (mysqli_num_rows($sql_ev) > 0) {
                            while ($row_ev = mysqli_fetch_assoc($sql_ev)) {
                                 ?>
                                 <option value="<?php echo $row_ev['id'];?>"><?php echo $row_ev['id']." - ".$row_ev['nome'];?></option>
                                 <?php
                            }
                        }
                        ?>
                    </select>
                </td>
            </tr>
            <tr align="left" class="tr-main-form">
                <td class="td-tit" name="td-tit">Valor</td>
                <td class="td-tit" name="td-tit"><input type="text" class="itxt-l" name="valor" placeholder="HH:MM:SS" value='<?= $row['valor']; ?>' required oninput="this.value = this.value.replace(/[^0-9,]/g, '').replace(/(\d{2})(\d)/, '$1:$2').replace(/(\d{2}:\d{2})(\d)/, '$1:$2').slice(0, 8);"></input></td>
            </tr>
            <tr align="left" class="tr-main-form">
                <td class="td-tit" name="td-tit">Observação</td>
                <td class="td-tit" name="td-tit"><input type="text" class="itxt-l" name="obs" placeholder="Informações adicionais"></input></td>
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