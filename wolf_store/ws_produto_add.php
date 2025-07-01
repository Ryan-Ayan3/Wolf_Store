<?php require_once('conn/conn.php'); ?>
<div class="div-us-create" id="div-us-create">
    <a href="" onclick="voltarPagina()" class="nav-link"><h1>Produtos</a> > Criar</h1>
    <form name="form-us-create" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="POST" onkeydown="return event.key != 'Enter';">
        <table class="main-table-form" id="main-table-form" align="center">
            <tr align="left">
                <td colspan="2" style="padding-bottom:20px;"><h2>Criar Produto</h2></td>
            </tr>
            <tr align="left" class="tr-main-form">
                <td class="td-tit" name="td-tit">Código</td>
                <td class="td-tit" name="td-tit"><input type="text" class="itxt-l" name="codigo" placeholder="Código Secundário"></input></td>
            </tr>
            <tr align="left" class="tr-main-form">
                <td class="td-tit" name="td-tit">Nome</td>
                <td class="td-tit" name="td-tit"><input type="text" class="itxt-l" name="nome" placeholder="Nome do Produto"></input></td>
            </tr>
            <tr align="left" class="tr-main-form">
                <td class="td-tit" name="td-tit">Unidade de Medida</td>
                <td class="td-tit" name="td-tit">
                    <select name="medida">
                        <option>SELECIONAR MEDIDA</option>
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
                        <option>SELECIONAR TIPO</option>
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
                <td class="td-tit" name="td-tit"><input type="text" class="itxt-l" name="peso" placeholder="Peso do Produto"></input></td>
            </tr>
            <tr align="left" class="tr-main-form">
                <td class="td-tit" name="td-tit">Preço</td>
                <td class="td-tit" name="td-tit"><input type="number" step="0.01" class="itxt-l" name="preco" placeholder="Preço do Produto"></input></td>
            </tr>
            <tr align="left" class="tr-main-form">
                <td class="td-tit" name="td-tit">Vincular Fornecedor</td>
                <td class="td-tit" name="td-tit">
                    <input type="text" class="itxt-l" name="fornecedor" id="pesquisador" autocomplete="off" value="" placeholder="Consulte um fornecedor"></input>
                    <input type="hidden" id="fornecedor_in" name="fornecedor_in" value=""></input></td>
            </tr>
            <tr align="left" class="tr-main-form">
                <td class="td-tit" name="td-tit"><td><div class="busca" id="busca"></div></td>
            </tr>
            <tr align="left" class="tr-main-form">
                <td class="td-tit" name="td-tit">Observação</td>
                <td class="td-tit" name="td-tit"><input type="text" class="itxt-l" name="obs" placeholder="Observações Adicionais"></input></td>
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