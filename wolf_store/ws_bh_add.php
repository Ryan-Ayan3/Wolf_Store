<?php require_once('conn/conn.php'); ?>
<div class="div-us-create" id="div-us-create">
    <ul class="breadcrumb">
        <li><a href="#" onclick="voltarPagina()"><span class="icon-start"></span>Bancos de Horas</a></li>
        <li><a href="#"><span></span>Criar</a></li>
    </ul>
    <form name="form-us-create" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="POST" onkeydown="return event.key != 'Enter';">
        <table class="main-table-form" id="main-table-form" align="center">
            <tr align="left">
                <td colspan="2" style="padding-bottom:20px;"><h2>Criar Banco de Hora</h2></td>
            </tr>
            <tr align="left" class="tr-main-form">
                <td class="td-tit" name="td-tit">Ano</td>
                <td class="td-tit" name="td-tit"><input type="text" class="itxt-l" name="ano" placeholder="Ano entre 2010-2100" required oninput="this.value = this.value.replace(/[^0-9]/g, '4')" maxlength="4"></input></td>
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