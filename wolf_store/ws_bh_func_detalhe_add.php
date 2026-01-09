<?php
require_once('conn/conn.php'); 
$idf = intval($_GET['idf']); //Conversor para tipo INT. Medida de segurança
?>
<div class="div-us-create" id="div-us-create">
    <ul class="breadcrumb">
        <li><a href="ws_bh.php"><span class="icon-start"></span>Bancos de Horas</a></li>
        <li><a href="ws_bh_func.php"><span></span>Funcionários</a></li>
        <li><a href="#" onclick="voltarPagina()"><span></span>Detalhe</a></li>
        <li><a href="#"><span></span>Criar</a></li>
    </ul>
    <form name="form-us-create" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="POST" onkeydown="return event.key != 'Enter';">
        <table class="main-table-form" id="main-table-form" align="center">
            <input type="hidden" name="idf" value="<?= $idf ?>">
            <tr align="left">
                <td colspan="2" style="padding-bottom:20px;"><h2>Criar Detalhe</h2></td>
            </tr>
            <tr aligh="left" class="tr-main-form">
                <td class="td-tit" name="td-tit">Evento</td>
                <td class="td-tit" name="td-tit">
                    <select name="evento">
                        <option value="0">SELECIONE EVENTO</option>
                        <?php
                        $sql_ev = mysqli_query($conn, "SELECT id, nome FROM evento WHERE ativo=1 AND (funcao=2 OR funcao=3) ORDER BY id ASC")or die(mysqli_error($conn));
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
                <td class="td-tit" name="td-tit"><input type="text" class="itxt-l" name="valor" placeholder="Dia(IBAP), Hora e Minuto" required oninput="this.value = this.value.replace(/[^0-9,]/g, '').replace(/(\d{2})(\d)/, '$1:$2').replace(/(\d{2}:\d{2})(\d)/, '$1:$2').slice(0, 8);"></input></td>
            </tr>
            <tr align="left" class="tr-main-form">
                <td class="td-tit" name="td-tit">Observação</td>
                <td class="td-tit" name="td-tit"><input type="text" class="itxt-l" name="obs" placeholder="Informações adicionais"></input></td>
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