<?php
    require_once('conn/conn.php');
    $id_edit = intval($_GET['id']); //Conversor para tipo INT. Medida de segurança
    $tabela_edit = preg_replace('/[^a-zA-Z0-9_]/', '', $_GET['tabela']); //Sanitização para permisão somente de letras, números e underline. Medida de segurança

    $sql = mysqli_query($conn, "SELECT * FROM $tabela_edit WHERE id=$id_edit") or die(mysqli_error($conn));
    $row = mysqli_fetch_assoc($sql);
    $temp = $row['uf'];
    $sql2 = mysqli_query($conn, "SELECT nome, uf FROM estados WHERE uf=$temp") or die(mysqli_error($conn));
    $row2 = mysqli_fetch_assoc($sql2);

    if ($row['alterado'] == NULL){
        $dataAlt = "Sem dado";
    } else {
        $dataAlt = date("H:i:s - d/m/Y", strtotime($row['alterado']));
    }
?>

<div class="div-us-edit">
    <a href="" onclick="voltarPagina()" class="nav-link"><h1>CLIENTES</a> > Edição</h1>
    <form name="form-us-edit" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="POST">
        <table class="main-table-form" align="center">
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
                <td class="td-tit" name="td-tit"><input type="number" class="itxt-l" name="cep" placeholder="Cep do cliente"></input></td>
            </tr>
            <tr align="left" class="tr-main-form">
                <td class="td-tit" name="td-tit">Município</td>
                <td class="td-tit" name="td-tit"><input type="text" class="itxt-l" name="municipio" placeholder="Município do cliente"></input></td>
            </tr>
            <tr align="left" class="tr-main-form">
                <td class="td-tit" name="td-tit">Bairro</td>
                <td class="td-tit" name="td-tit"><input type="text" class="itxt-l" name="bairro" placeholder="Bairro do cliente"></input></td>
            </tr>
              <tr align="left" class="tr-main-form">
                <td class="td-tit" name="td-tit">Rua</td>
                <td class="td-tit" name="td-tit"><input type="text" class="itxt-l" name="rua" placeholder="Rua do cliente"></input></td>
            </tr>
            <tr align="left" class="tr-main-form">
                <td class="td-tit" name="td-tit">Endereço</td>
                <td class="td-tit" name="td-tit"><input type="text" class="itxt-l" name="endereco" placeholder="Endereço do cliente"></input></td>
            </tr>
            <tr align="left" class="tr-main-form">
                <td class="td-tit" name="td-tit">Complemento</td>
                <td class="td-tit" name="td-tit"><input type="text" class="itxt-l" name="complemento" placeholder="Complemento do endereço"></input></td>
            </tr>
            <tr align="left" class="tr-main-form">
                <td class="td-tit" name="td-tit">Contato</td>
                <td class="td-tit" name="td-tit"><input type="text" class="itxt-l" name="contato" placeholder="Contato do cliente"></input></td>
            </tr>
            <tr align="left" class="tr-main-form">
                <td class="td-tit" name="td-tit">Email</td>
                <td class="td-tit" name="td-tit"><input type="text" class="itxt-l" name="email" placeholder="Email do cliente"></input></td>
            </tr>
            <tr align="left" class="tr-main-form">
                <td class="td-tit" name="td-tit">Observação</td>
                <td class="td-tit" name="td-tit"><input type="text" class="itxt-l" name="obs" placeholder="Informações Adicionais"></input></td>
            </tr>
            <tr align="left" class="tr-main-form">
                <td class="td-tit" name="td-tit">Alterado</td>
                <td class="td-tit" name="td-tit"><input type="text" class="itxt-l" disabled value="<?php echo $dataAlt;?>"></input></td>
            </tr>
            <tr align="center">
                <td colspan="2">
                    <input onclick="createRegistro()" type="button" class="sub-create" name="sub-create" value="Enviar"></input>
                    <input onclick="voltarPagina()" type="button" class="sub-back" name="sub-back" value="Voltar"></input>
                </td>
            </tr>
        </table>
    </form>
</div>