<?php require_once('conn/conn.php'); ?>
<div class="div-us-create" id="div-us-create">
    <a href="" onclick="voltarPagina()" class="nav-link"><h1>Fornecedores</a> > Criar</h1>
    <form name="form-us-create" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="POST" onkeydown="return event.key != 'Enter';">
        <table class="main-table-form" id="main-table-form" align="center">
            <tr align="left">
                <td colspan="2" style="padding-bottom:20px;"><h2>Criar Fornecedor</h2></td>
            </tr>
            <tr align="left" class="tr-main-form">
                <td class="td-tit" name="td-tit">Nome</td>
                <td class="td-tit" name="td-tit"><input type="text" class="itxt-l" name="nome" placeholder="Nome do Cliente" required></input></td>
            </tr>
            <tr align="left" class="tr-main-form">
                <td class="td-tit" name="td-tit">CPF/CNPJ</td>
                <td class="td-tit" name="td-tit"><input type="text" class="itxt-l" name="cadastro" inputmode="numeric" pattern="[0-9]*" maxlength="14" title="Digite apenas números" placeholder="CPF ou CNPJ do cliente"></input></td>
            </tr>
            <tr align="left" class="tr-main-form">
                <td class="td-tit" name="td-tit">UF</td>
                <td class="td-tit" name="td-tit">
                    <select name="uf">
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
            <tr align="center">
                <td colspan="2">
                    <input onclick="createRegistro()" type="button" class="sub-create" name="sub-create" value="Enviar"></input>
                    <input onclick="voltarPagina()" type="button" class="sub-back" name="sub-back" value="Voltar"></input>
                </td>
            </tr>
        </table>
    </form>
</div>