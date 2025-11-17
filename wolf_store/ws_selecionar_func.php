<?php
    require_once('scripts/ws_credencial.php');
    include_once('scripts/ws_logoff.php');
    require_once('conn/conn.php');
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
        window.location.href = "ws_bh.php";
    }
</script>
<?php
    /* http://10.0.33.33/wolf_store/wolf_store/ws_selecionar_func.php
    unset($_SESSION['id_naveg']);
    unset($_SESSION['dest_naveg']);
    */
    include_once('scripts/ws_vbar.html');
    if (!isset($_SESSION['id_naveg']) || !isset($_SESSION['dest_naveg'])) {
        echo "<script>alert('Nenhum ID encontrado'); window.history.back();</script>";
    } else {
        if ($_SESSION['dest_naveg'] == "bancohora") {
            $id_sel = $_SESSION['id_naveg'];
            $dest_naveg = "scripts/ws_include_bh_mult.php";
            $sql = mysqli_query($conn, "SELECT 
                                            f.id AS fid, f.matr AS fmatr, f.nome AS fnome,
                                            d.nome AS dpnome,
                                            s.nome AS senome,
                                            ff.nome AS ffnome,
                                            g.nome AS gnome
                                        FROM funcionario f
                                        JOIN departamento d ON f.fk_departamento = d.id
                                        JOIN setor s ON f.fk_setor = s.id
                                        JOIN funcao ff ON f.fk_funcao = ff.id
                                        JOIN grupo g ON f.fk_grupo = g.id
                                        LEFT JOIN banco_horas_func bhf ON f.matr = bhf.fk_matr
                                        AND bhf.fk_banco_horas = $id_sel
                                        AND bhf.ativo = 1
                                        LEFT JOIN banco_horas bh ON bhf.fk_banco_horas = bh.id 
                                        AND bh.id = $id_sel
                                        WHERE 
                                            f.ativo = 1 AND
                                            f.afastado = 0 AND
                                            bh.id IS NULL
                                        GROUP BY f.matr
                                        ORDER BY f.nome ASC;") or die($conn);
        } elseif ($_SESSION['dest_naveg'] == "folha") {
            $dest_naveg = "";
        } else {
            unset($_SESSION['id_naveg']);
            unset($_SESSION['dest_naveg']);
            echo "<script>alert('Navegação Incorreta'); window.history.back();</script>";
        }
        ?>
        <div class="conteudo">
            <a href="#" onclick="voltarPagina()" class="nav-link"><h1>Bancos de Horas</a> > SELECIONAR FUNCIONÁRIO</h1>
            <h4>Obs: Lista apenas de funcionário não inclusos na operação</h4>
            <div class="content-table">
                <form name="form-us" action="<?=$dest_naveg?>" method="POST">
                    <table class="main-table" align="center">
                        <?php
                            if (mysqli_num_rows($sql) <= 15 && mysqli_num_rows($sql) > 0) {
                                ?>
                                <tr align="center" class="tr-cab">
                                    <td class="td-cab"></td>
                                    <td class="td-cab">Matrícula</td>
                                    <td class="td-cab">Nome</td>
                                    <td class="td-cab">Departamento</td>
                                    <td class="td-cab">Setor</td>
                                    <td class="td-cab">Função</td>
                                    <td class="td-cab">Grupo</td>
                                </tr>
                                <?php
                                while($row = mysqli_fetch_assoc($sql)) { 
                                    echo "
                                        <tr align='left' class='tr-main'>
                                            <td><input type='checkbox' class='icheckbox' checked name='ids[]' value='".$row['fid']."'></td>
                                            <td align='center'>".$row['fmatr']."</td>
                                            <td align='left'>".$row['fnome']."</td>
                                            <td align='left'>".$row['dpnome']."</td>
                                            <td align='left'>".$row['senome']."</td>
                                            <td align='center'>".$row['ffnome']."</td>
                                            <td align='center'>".$row['gnome']."</td>
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