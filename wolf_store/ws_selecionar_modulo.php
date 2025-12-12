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
        if ($_SESSION['dest_naveg'] == "bancohora") {
            $id_sel = $_SESSION['id_naveg'];
            
            $dest_naveg = "scripts/ws_include_.php";
            //Busca todos os funcionários que estão ativos e que já não estão vinculados ao Banco_horas especifico
            $sql = mysqli_query($conn, "SELECT 
                                            *
                                        FROM
                                            modulo m
                                        WHERE 
                                            m.ativo=1") or die($conn);
        } elseif ($_SESSION['dest_naveg'] == "folha") {
            $dest_naveg = "";
        } else {
            unset($_SESSION['id_naveg']);
            unset($_SESSION['dest_naveg']);
            echo "<script>alert('Navegação Incorreta'); window.history.back();</script>";
        }
        ?>
        <div class="conteudo">
            <a href="#" onclick="voltarPagina()" class="nav-link"><h1>Níveis</a> > SELECIONAR MÓDULO</h1>
            <h4>Obs: Lista apenas de MÓDULOS não inclusos no Nível</h4>
            <div class="content-table">
                <form name="form-us" action="<?=$dest_naveg?>" method="POST">
                    <table class="main-table" align="center">
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
                                    $id_pai = $row['id_pai'];
                                    if (!empty($id_pai)) {
                                        $sql2 = mysqli_query($conn, "SELECT nome
                                                                    FROM $tabela
                                                                    WHERE ativo = 1 
                                                                    AND id = '$id_pai'
                                                                    AND id < 50") or die(mysqli_error($conn));
                                        $row2 = mysqli_fetch_assoc($sql2);

                                        if (!empty($row2['nome'])) {
                                            $moduloPai = $row2['nome'];
                                        } else {
                                            $moduloPai = "Não Há";
                                        }

                                    } else {
                                        $moduloPai = "Não Há";
                                    }
                                    echo "
                                        <tr align='left' class='tr-main'>
                                            <td><input type='checkbox' class='icheckbox' checked name='ids[]' value='".$row['fid']."'></td>
                                            <td align='center'>".$row['nome']."</td>
                                            <td align='left'>".$$moduloPai."</td>
                                        </tr>";
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