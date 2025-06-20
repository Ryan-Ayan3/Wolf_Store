<?php require_once('conn/conn.php'); ?>
<div class="div-us-create">
    <a href="" onclick="voltarPagina()" class="nav-link"><h1>Unidades de Medidas</a> > Criar</h1>
    <form name="form-us-create" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="POST" onkeydown="return event.key != 'Enter';">
        <table class="main-table-form" align="center">
            <tr align="left">
                <td colspan="2" style="padding-bottom:20px;"><h2>Criar Unidade de Medida</h2></td>
            </tr>
            <tr align="left" class="tr-main-form">
                <td class="td-tit" name="td-tit">Nome</td>
                <td class="td-tit" name="td-tit"><input type="text" class="itxt-l" name="nome" placeholder="Nome do Movimento" required></input></td>
            </tr>
            <tr align="left" class="tr-main-form">
                <td class="td-tit" name="td-tit">Tipo Valor</td>
                <td class="td-tit" name="td-tit">
                    <select name="tipoValor">
                        <option>SELECIONE TIPO</option>
                        <option value='1'>1 - Inteiro</option>
                        <option value='2'>2 - Decimal</option>
                    </select>
                </td>
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