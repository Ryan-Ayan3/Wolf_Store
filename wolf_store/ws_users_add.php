<?php require_once('conn/conn.php'); ?>
<div class="div-us-create" id="div-us-create">
    <a href="" onclick="voltarPagina()" class="nav-link"><h1>USUÁRIOS</a> > Criar</h1>
    <form name="form-us-create" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="POST" onkeydown="return event.key != 'Enter';">
        <table class="main-table-form" id="main-table-form" align="center">
            <tr align="left">
                <td colspan="2" style="padding-bottom:20px;"><h2>Criar Usuário</h2></td>
            </tr>
            <tr align="left" class="tr-main-form">
                <td class="td-tit" name="td-tit">Login</td>
                <td class="td-tit" name="td-tit"><input type="text" class="itxt-l" name="login" placeholder="Login de acesso" required></input></td>
            </tr>
            <tr align="left" class="tr-main-form">
                <td class="td-tit" name="td-tit">Definir Senha</td>
                <td class="td-tit" name="td-tit"><input type="text" class="itxt-l" name="senha" placeholder="Senha de acesso" required></input></td>
            </tr>
            <tr align="left" class="tr-main-form">
                <td class="td-tit" name="td-tit">Nível</td>
                <td class="td-tit" name="td-tit">
                    <select name="nivel">
                        <option>SELECIONE NÍVEL</option>
                        <?php 
                            $sql_nivel = mysqli_query($conn, "SELECT nome, nivel FROM nivel_ac WHERE ativo=1") or die(mysqli_error($conn));
                            if (mysqli_num_rows($sql_nivel) > 0) {
                                while($row_nivel = mysqli_fetch_assoc($sql_nivel)) {
                                    ?>
                                    <option value="<?php echo $row_nivel['nivel'];?>"><?php echo $row_nivel['nivel']." - ".$row_nivel['nome']; ?></option>
                                    <?php
                                }
                            }
                        ?>
                    </select>
                </td>
            </tr>
            <tr align="left" class="tr-main-form">
                <td class="td-tit" name="td-tit">Email</td>
                <td class="td-tit" name="td-tit"><input type="text" class="itxt-l" name="email" placeholder="Gmail do usuário" required></input></td>
            </tr>
            <tr align="left" class="tr-main-form">
                <td class="td-tit" name="td-tit">Cargo</td>
                <td class="td-tit" name="td-tit"><input type="text" class="itxt-l" name="cargo" placeholder="Cargo do usuário" required></input></td>
            </tr>
            <tr align="left" class="tr-main-form">
                <td class="td-tit" name="td-tit">Nome</td>
                <td class="td-tit" name="td-tit"><input type="text" class="itxt-l" name="nome" placeholder="Nome do usuário" required></input></td>
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