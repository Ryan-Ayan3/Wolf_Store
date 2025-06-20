<?php require_once('conn/conn.php'); ?>
<div class="div-us-create">
    <a href="" onclick="voltarPagina()" class="nav-link"><h1>Clientes</a> > Criar</h1>
    <form name="form-us-create" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="POST" onkeydown="return event.key != 'Enter';">
        <table class="main-table-form" align="center">
            <tr align="left">
                <td colspan="2" style="padding-bottom:20px;"><h2>Criar Cliente</h2></td>
            </tr>
            <tr align="left" class="tr-main-form">
                <td class="td-tit" name="td-tit">Nome</td>
                <td class="td-tit" name="td-tit"><input type="text" class="itxt-l" name="nome" placeholder="Nome do Cliente" required></input></td>
            </tr>
            <tr align="left" class="tr-main-form">
                <td class="td-tit" name="td-tit">CPF/CNPJ</td>
                <td class="td-tit" name="td-tit"><input type="number" class="itxt-l" name="nome" placeholder="CPF ou CNPJ do cliente" required></input></td>
            </tr>
            <tr align="left" class="tr-main-form">
                <td class="td-tit" name="td-tit">UF</td>
                <td class="td-tit" name="td-tit">
                    <select name="tipoValor">
                        <option>SELECIONE UF</option>
                        <?php
                        $sql_uf = mysqli_query($conn, "SELECT codg, nome, uf FROM estados")or die($conn);
                        if (mysqli_num_rows($sql_uf) > 0) {
                            while ($row_uf = mysqli_fetch_assoc($sql_uf) > 0) {
                                 
                            }
                        }
                        ?>
                        <option value='1'>1 - Inteiro</option>
                        <option value='2'>2 - Decimal</option>
                    </select>
                </td>
            </tr>
            <tr align="left" class="tr-main-form">
                <td class="td-tit" name="td-tit">CEP</td>
                <td class="td-tit" name="td-tit"><input type="number" class="itxt-l" name="nome" placeholder="Cep do cliente" required></input></td>
            </tr>
            <tr align="left" class="tr-main-form">
                <td class="td-tit" name="td-tit">Município</td>
                <td class="td-tit" name="td-tit"><input type="text" class="itxt-l" name="nome" placeholder="Município do cliente" required></input></td>
            </tr>
            <tr align="left" class="tr-main-form">
                <td class="td-tit" name="td-tit">Bairro</td>
                <td class="td-tit" name="td-tit"><input type="text" class="itxt-l" name="nome" placeholder="Bairro do cliente" required></input></td>
            </tr>
            <tr align="left" class="tr-main-form">
                <td class="td-tit" name="td-tit">Endereço</td>
                <td class="td-tit" name="td-tit"><input type="text" class="itxt-l" name="nome" placeholder="Endereço do cliente" required></input></td>
            </tr>
            <tr align="left" class="tr-main-form">
                <td class="td-tit" name="td-tit">Rua</td>
                <td class="td-tit" name="td-tit"><input type="text" class="itxt-l" name="nome" placeholder="Rua do cliente" required></input></td>
            </tr>
            <tr align="left" class="tr-main-form">
                <td class="td-tit" name="td-tit">Complemento</td>
                <td class="td-tit" name="td-tit"><input type="text" class="itxt-l" name="nome" placeholder="Complemento do endereço" required></input></td>
            </tr>
            <tr align="left" class="tr-main-form">
                <td class="td-tit" name="td-tit">Contato</td>
                <td class="td-tit" name="td-tit"><input type="text" class="itxt-l" name="nome" placeholder="Contato do cliente" required></input></td>
            </tr>
            <tr align="left" class="tr-main-form">
                <td class="td-tit" name="td-tit">Email</td>
                <td class="td-tit" name="td-tit"><input type="text" class="itxt-l" name="nome" placeholder="Email do cliente" required></input></td>
            </tr>
            <tr align="left" class="tr-main-form">
                <td class="td-tit" name="td-tit">Observação</td>
                <td class="td-tit" name="td-tit"><input type="text" class="itxt-l" name="nome" placeholder="Informações Adicionais" required></input></td>
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