<?php require_once('conn/conn.php'); 

$idbh = intval($_GET['idbh']); //Conversor para tipo INT. Medida de segurança

?>
<div class="div-us-create" id="div-us-create">
    <a href="ws_bh.php" class="nav-link"><h1>Bancos de Horas</a> > <a href="" onclick="voltarPagina()" class="nav-link">Funcionários</a> > Inserir</h1>
    <form name="form-us-create" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="POST" onkeydown="return event.key != 'Enter';">
        <table class="main-table-form" id="main-table-form" align="center">
            <tr align="left">
                <td colspan="2" style="padding-bottom:20px;"><h2>Inserir Funcionário</h2></td>
            </tr>
            <tr align="left" class="tr-main-form">
                <td class="td-tit" name="td-tit">Buscar Funcionário</td>
                <td class="td-tit" name="td-tit">
                    <input type="text" class="itxt-l" name="funcionario" id="pesquisador" autocomplete="off" value="" placeholder="Digite matrícula ou nome"></input>
                    <input type="hidden" id="funcionario_in" name="funcionario_in" value=""></input></td>
            </tr>
            <tr align="left">
                <td class="td-tit" name="td-tit"><td><div class="busca" id="busca"></div></td>
            </tr>
            <tr align="left" class="tr-main-form">
                <td class="td-tit" name="td-tit">Observação</td>
                <td class="td-tit" name="td-tit"><input type="text" class="itxt-l" name="obs" placeholder="Observações Adicionais"></input></td>
            </tr>
            <tr align="center">
                <td colspan="2">
                    <input onclick="createRegistro('<?= $idbh ?>')" type="button" class="sub-create" name="sub-create" value="Enviar"></input>
                    <input onclick="voltarPagina()" type="button" class="sub-back" name="sub-back" value="Voltar"></input>
                </td>
            </tr>
        </table>
    </form>
</div>