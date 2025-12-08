<?php require_once('conn/conn.php'); ?>
<div class="div-us-create" id="div-us-create">
    <a href="" onclick="voltarPagina()" class="nav-link"><h1>Módulos</a> > Criar</h1>
    <form name="form-us-create" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="POST" onkeydown="return event.key != 'Enter';">
        <table class="main-table-form" id="main-table-form" align="center">
            <tr align="left">
                <td colspan="2" style="padding-bottom:20px;"><h2>Criar Módulo</h2></td>
            </tr>
            <tr aligh="left" class="tr-main-form">
                <td class="td-tit" name="td-tit">Nome</td>
                <td class="td-tit" name="td-tit"><input type="text" class="itxt-l" name="nome" placeholder="Nome do Módulo" required></input></td>
            </tr>
            <tr aligh="left" class="tr-main-form">
                <td class="td-tit" name="td-tit">Módulo Associado</td>
                <td class="td-tit" name="td-tit">
                    <select name="setor" id="sl-setor">
                        <option value="0">SELECIONE MÓDULO</option>
                        <?php
                        $sql_setor = mysqli_query($conn, "SELECT id, nome FROM modulo WHERE ativo=1 AND id < 50 ORDER BY nome ASC")or die(mysqli_error($conn));
                        if (mysqli_num_rows($sql_setor) > 0) {
                            while ($row_setor = mysqli_fetch_assoc($sql_setor)) {
                                 ?>
                                 <option value="<?php echo $row_setor['id'];?>"><?php echo $row_setor['id']." - ".$row_setor['nome'];?></option>
                                 <?php
                            }
                        }
                        ?>
                    </select>
                </td>
            </tr>
            <tr aligh="left" class="tr-main-form">
                <td class="td-tit" name="td-tit">É Módulo Pai?</td>
                <td class="td-tit" name="td-tit"><input type='checkbox' class='icheckbox' name='ePai' id="cb-epai" value='pai'></input></td>
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