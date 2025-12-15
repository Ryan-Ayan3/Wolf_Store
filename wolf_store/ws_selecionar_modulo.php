<?php
    require_once('scripts/ws_credencial.php');
    include_once('scripts/ws_logoff.php');
    require_once('conn/conn.php');
    require_once('scripts/autenticar.php');

    if (!moduloPermissao('Módulo', $conn)) {
        echo "<script>alert('Área restrita para seu nível'); window.history.back();</script>";
    }
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="author" content="Rian I. Silva" />
    <title>Wolf Store</title>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="icon" type="image/x-icon" href="imgs/wolf_store_logo.jpg">
</head>
<body>
<script>
    function voltarPagina() {
        window.history.back();
    }
</script>
<?php
    include_once('scripts/ws_vbar.php');
    if (!isset($_SESSION['id_nivel'])) {
        echo "<script>alert('Nenhum ID encontrado'); window.history.back();</script>";
    } else {
        $id_nivel = $_SESSION['id_nivel'];
        
        $dest_naveg = "scripts/ws_include_modulo.php";
        //Busca todos os funcionários que estão ativos e que já não estão vinculados ao Banco_horas especifico
        $sql = mysqli_query($conn, "SELECT 
                                        m.id as idModulo, m.nome AS nomeModulo, m.id_pai AS idPai,
                                        n.id AS nivel_Id,
                                        mp.id AS perm_id
                                    FROM
                                        modulo m
                                    LEFT JOIN nivel n ON n.id = $id_nivel
                                    AND n.ativo = 1
                                    LEFT JOIN modulo_permissao mp ON m.id = mp.fk_modulo
                                    AND n.id = mp.fk_nivel
                                    AND mp.ativo = 1
                                    WHERE 
                                        m.ativo=1
                                    ORDER BY idPai ASC, nomeModulo ASC") or die($conn);
        ?>
        <div class="conteudo">
            <a href="#" onclick="voltarPagina()" class="nav-link"><h1>Níveis</a> > SELECIONAR MÓDULO</h1>
            <div class="content-table">
                <form name="form-us" action="<?=$dest_naveg?>" method="POST">
                    <table class="main-table-compact" align="center">
                        <?php
                            if (mysqli_num_rows($sql) > 0) {
                                ?>
                                <tr align="center" class="tr-cab">
                                    <td class="td-cab"></td>
                                    <td class="td-cab">Nome</td>
                                    <td class="td-cab">Módulo Pai</td>
                                </tr>
                                <?php
                                while($row = mysqli_fetch_assoc($sql)) {
                                    $id_pai = $row['idPai'];
                                    if (!empty($id_pai)) {
                                        $sql2 = mysqli_query($conn, "SELECT nome
                                                                    FROM modulo
                                                                    WHERE ativo = 1 
                                                                    AND id = '$id_pai'
                                                                    AND id < 50") or die(mysqli_error($conn));
                                        $row2 = mysqli_fetch_assoc($sql2);
                                        $moduloPai = $row2['nome'];
                                    } else {
                                        $moduloPai = "";
                                    }
                                    ?>
                                    <tr align="left" class="tr-main">
                                        <input type="hidden" name="ids[<?= $row['idModulo']?>]" value="0">
                                        <td><input type="checkbox" class="icheckbox" name="ids[<?= $row['idModulo']?>]" value="1" <?php if (!empty($row['perm_id'])) { echo "checked";} ?>></td>
                                        <td align="left"><?= $row['nomeModulo']?></td>
                                        <td align="left"><?= $moduloPai?></td>
                                    </tr>
                                    <?php
                                }
                            } else {
                                include_once('scripts/mensagem_nodata.html');
                            }
                        ?>
                    </table>
                    <button type="submit" class="sub-content-send">
                        <div class="content-send">
                            <div class="img-send">
                                <span>Enviar Dados</span>
                            </div>
                        </div>
                    </button>
                    <button type="button" onclick="voltarPagina()" class="sub-content-back">
                        <div class="content-back">
                            <div class="img-back">
                                <span>Voltar</span>
                            </div>
                        </div>
                    </button>
                </form>
            </div>
        </div>
        <?php
    }
?>
</body>
</html>