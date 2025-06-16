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
                        <?php  /*
                            $sql_tipo = mysqli_query($conn, "SELECT tipoValor FROM unidade_medida WHERE ativo=1") or die(mysqli_error($conn));
                            if (mysqli_num_rows($sql_nivel) > 0) {
                                while($row_tipo = mysqli_fetch_assoc($sql_nivel)) {
                                    if($row_tipo['tipoValor'] == 1) {
                                        $tipoValor = "Inteiro";
                                    } elseif($row_tipo['tipoValor'] == 2) {
                                        $tipoValor = "Decimal";
                                    }
                                    ?>
                                    <option value="<?php echo $row_tipo['nivel'];?>"><?php echo "OP ".$numero." - ".$tipoValor['nome'];?></option>
                                    <?php
                                    $numero++;
                                }
                            } */
                        ?>
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