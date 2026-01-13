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
        <li><a href="#" onclick="voltarPagina()"><span class="icon-start"></span>Módulos</a></li>
        <li><a href="#" onclick="voltarPagina()"><span></span>Edição</a></li>
    </ul>
    <form name="form-us-edit" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="POST">
        <table class="main-table-form" id="main-table-form" align="center">
            <tr align="left">
                <td colspan="2" style="padding-bottom:20px;"><h2>Editar Funcionário</h2></td>
            </tr>
            <tr aligh="left" class="tr-main-form">
                <td class="td-tit" name="td-tit">Nome</td>
                <td class="td-tit" name="td-tit"><input type="text" class="itxt-l" name="nome" value="<?= $row['nome']?>" required></input></td>
            </tr>
            <tr aligh="left" class="tr-main-form">
                <td class="td-tit" name="td-tit">Módulo Associado</td>
                <td class="td-tit" name="td-tit">
                    <?php 
                    //SE MÓDULO FOR FILHO
                    if (!empty($row['id_pai'])) {
                        ?>
                        <input type="hidden" name="mark" id="mark" value="A2"></input>
                        <select name="modulo" id="sl-modulo">
                        <option value="<?= $row['id_pai']?>"><?= $row['nome']?></option>
                        <?php
                    // SE MÓDULO FOR PAI
                    } else {
                        ?>
                        <input type="hidden" name="mark" id="mark" value="A1"></input>
                        <select name="modulo" id="sl-modulo">
                        <?php
                    }
                    ?>
                        <option value="0">SELECIONE MÓDULO</option>
                        <?php
                        $sql_modulo = mysqli_query($conn, "SELECT id, nome FROM modulo WHERE ativo=1 AND id < 50 AND id <> $id_edit ORDER BY id ASC")or die(mysqli_error($conn));
                        if (mysqli_num_rows($sql_modulo) > 0) {
                            while ($row_modulo = mysqli_fetch_assoc($sql_modulo)) {
                                 ?>
                                 <option value="<?php echo $row_modulo['id'];?>"><?php echo $row_modulo['id']." - ".$row_modulo['nome'];?></option>
                                 <?php
                            }
                        }
                        ?>
                    </select>
                </td>
            </tr>
            <tr aligh="left" class="tr-main-form">
                <td class="td-tit" name="td-tit">É Módulo Pai?</td>
                <td class="td-tit" name="td-tit">
                    <input type="radio" class="iradio" name='ePai' id="cb-epai" value="1" required <?php if (empty($row['id_pai'])){echo "checked";} ?>>Sim</input>
                    <input type="radio" class="iradio" name='ePai' id="cb-epai" value="0" required <?php if (!empty($row['id_pai'])){echo "checked";} ?>>Não</input> 
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