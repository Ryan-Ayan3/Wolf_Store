<?php
    require_once('conn/conn.php');
    $id_edit = intval($_GET['id']); //Conversor para tipo INT. Medida de segurança
    $tabela_edit = preg_replace('/[^a-zA-Z0-9_]/', '', $_GET['tabela']); //Sanitização para permisão somente de letras, números e underline. Medida de segurança

    $sql = mysqli_query($conn, "SELECT * FROM $tabela_edit WHERE id=$id_edit") or die(mysqli_error($conn));
    $row = mysqli_fetch_assoc($sql);
    $temp = $row['uf'];
    $sql2 = mysqli_query($conn, "SELECT nome, uf FROM estados WHERE uf='$temp'") or die(mysqli_error($conn));
    $row2 = mysqli_fetch_assoc($sql2);

    if ($row['alterado'] == NULL){
        $dataAlt = "Sem dado";
    } else {
        $dataAlt = date("H:i:s - d/m/Y", strtotime($row['alterado']));
    }
?>

<div class="div-us-edit" id="div-us-edit">
    <ul class="breadcrumb">
        <li><a href="#" onclick="voltarPagina()"><span class="icon-start"></span>Clientes</a></li>
        <li><a href="#" onclick="voltarPagina()"><span></span>Edição</a></li>
    </ul>
    <form name="form-us-edit" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="POST">
        <table class="main-table-form" id="main-table-form" align="center">
            <tr align="left">
                <td colspan="2" style="padding-bottom:20px;"><h2>Criar Cliente</h2></td>
            </tr>
            <tr align="left" class="tr-main-form">
                <td class="td-tit" name="td-tit">Nome</td>
                <td class="td-tit" name="td-tit"><input type="text" class="itxt-l" name="nome" value="<?php echo $row['nome'];?>" required></input></td>
            </tr>
            <tr align="left" class="tr-main-form">
                <td class="td-tit" name="td-tit">CPF/CNPJ</td>
                <td class="td-tit" name="td-tit">
                    <input type="text" class="itxt-l" name="cadastro" inputmode="numeric" pattern="[0-9]*" maxlength="14" title="Digite apenas números" value="<?php   
                        if ($row['cpf'] != "") {
                            echo $row['cpf'];
                        } elseif($row['cnpj'] != "") {
                            echo $row['cnpj'];
                        } else {
                            echo "";
                        }?>">
                    </input>
                </td>
            </tr>
            <tr align="left" class="tr-main-form">
                <td class="td-tit" name="td-tit">UF</td>
                <td class="td-tit" name="td-tit">
                    <select name="uf">
                        <option value="<?php echo $row2['uf'];?>"><?php echo $row2['nome'];?></option>
                        <option value="00">SELECIONE UF</option>
                        <?php
                        $sql_uf = mysqli_query($conn, "SELECT id, codg, nome, uf FROM estados WHERE ativo=1 ORDER BY nome ASC")or die(mysqli_error($conn));
                        if (mysqli_num_rows($sql_uf) > 0) {
                            while ($row_uf = mysqli_fetch_assoc($sql_uf)) {
                                 ?>
                                 <option value="<?php echo $row_uf['uf'];?>"><?php echo $row_uf['uf']." - ".$row_uf['nome'];?></option>
                                 <?php
                            }
                        }
                        ?>
                    </select>
                </td>
            </tr>
            <tr align="left" class="tr-main-form">
                <td class="td-tit" name="td-tit">CEP</td>
                <td class="td-tit" name="td-tit"><input type="number" class="itxt-l" name="cep" value="<?php echo $row['cep'];?>"></input></td>
            </tr>
            <tr align="left" class="tr-main-form">
                <td class="td-tit" name="td-tit">Município</td>
                <td class="td-tit" name="td-tit"><input type="text" class="itxt-l" name="municipio" value="<?php echo $row['municipio'];?>"></input></td>
            </tr>
            <tr align="left" class="tr-main-form">
                <td class="td-tit" name="td-tit">Bairro</td>
                <td class="td-tit" name="td-tit"><input type="text" class="itxt-l" name="bairro" value="<?php echo $row['bairro'];?>"></input></td>
            </tr>
              <tr align="left" class="tr-main-form">
                <td class="td-tit" name="td-tit">Rua</td>
                <td class="td-tit" name="td-tit"><input type="text" class="itxt-l" name="rua" value="<?php echo $row['rua'];?>"></input></td>
            </tr>
            <tr align="left" class="tr-main-form">
                <td class="td-tit" name="td-tit">Endereço</td>
                <td class="td-tit" name="td-tit"><input type="text" class="itxt-l" name="endereco" value="<?php echo $row['endereco'];?>"></input></td>
            </tr>
            <tr align="left" class="tr-main-form">
                <td class="td-tit" name="td-tit">Complemento</td>
                <td class="td-tit" name="td-tit"><input type="text" class="itxt-l" name="complemento" value="<?php echo $row['complemento'];?>"></input></td>
            </tr>
            <tr align="left" class="tr-main-form">
                <td class="td-tit" name="td-tit">Contato</td>
                <td class="td-tit" name="td-tit"><input type="text" class="itxt-l" name="contato" value="<?php echo $row['contato'];?>"></input></td>
            </tr>
            <tr align="left" class="tr-main-form">
                <td class="td-tit" name="td-tit">Email</td>
                <td class="td-tit" name="td-tit"><input type="text" class="itxt-l" name="email" value="<?php echo $row['email'];?>"></input></td>
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