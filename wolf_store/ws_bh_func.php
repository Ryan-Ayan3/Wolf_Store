<?php
    require_once('scripts/ws_credencial.php');
    include_once('scripts/ws_logoff.php');
    require_once('conn/conn.php');
    include_once('scripts/ws_time.php');
    require_once('scripts/autenticar.php');

    if (!moduloPermissao('Banco de Horas', $conn)) {
        echo "<script>alert('Área restrita para seu nível'); window.history.back();</script>";
    }

    if (!isset($_SESSION['id_alfa'])) {
        echo "<script>alert('Acesso inválido ou tempo expirado.'); window.history.back();</script>";
        exit;
    }
    $id_alfa = (int) $_SESSION['id_alfa'];
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
        function deleteRegistro(matr,idalfa,tabela) {
            if(confirm("Deletar registro?")) {
                fetch('scripts/ws_delete_bh_func.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: 'matr='+encodeURIComponent(matr)+'&idalfa='+encodeURIComponent(idalfa)+'&tabela='+encodeURIComponent(tabela)
                })
                .then(response => response.text())
                .then(data => {
                    if (data === "ok") {
                        location.reload(); // só recarrega se der certo
                    } else {
                        alert("Erro ao excluir: " + data);
                    }
                });
            }
        }

        function includeRegistro(id,dest) {
            fetch('scripts/ws_naveg_bh.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: 'id='+encodeURIComponent(id)+'&dest='+encodeURIComponent(dest)
            })
            .then(response => response.text())
            .then(data => {
                if (data === "ok") {
                    window.location.href = "ws_selecionar_func.php";
                } else {
                    alert("Atenção, Mensagem: " + data);
                }
            });
        }

        function creatorRegistro(idbh) {
            fetch('ws_bh_func_add.php?idbh='+encodeURIComponent(idbh))
            .then(response => response.text())
            .then(html => {
                const container = document.getElementById('workInfor');
                container.innerHTML = html;
                /* ESC para voltar*/
                document.addEventListener("keydown", function(event) {
                    if (event.key === "Escape") {
                        location.reload();
                    }
                });
                /* BUSCA Registro através de Input */
                document.getElementById('pesquisador').addEventListener('input', function () {
                    const intel = this.value;

                    if (intel.length < 1) {
                        document.getElementById('busca').innerHTML = '';
                        return;
                    }

                    fetch('scripts/buscar_funcionario.php?i='+encodeURIComponent(intel)+'&idbh='+encodeURIComponent(idbh))
                        .then(resp => resp.text())
                        .then(dados => {
                        document.getElementById('busca').innerHTML = dados;
                        });
                });
                /* Click para selecionar registro */
                document.addEventListener('click', function(e) {
                    if (e.target.classList.contains('busca-item')) {
                        const in2 = e.target.getAttribute('data-in2');
                        document.getElementById('pesquisador').value = e.target.textContent;
                        document.getElementById('funcionario_in').value = in2;
                        document.getElementById('busca').innerHTML = '';
                    }
                });

                /* Click fora do MODAL para voltar */
                const modal = document.getElementById('main-table-form');
                const div1 = document.getElementById('div-us-create');
                const div2 = document.getElementById('workInfor');

                function voltarPagina2(event) {
                if (!modal.contains(event.target)) {
                    location.reload();
                }
                }
                div1.addEventListener('click', voltarPagina2);
                div2.addEventListener('click', voltarPagina2);
            });
            workInfor.style.display = 'block';
        }

        function createRegistro(idbh) {
            const form = document.forms['form-us-create'];
            const funcionario = form.funcionario_in.value;

            fetch('scripts/ws_include_bh_solo.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: 
                    'idbh='+encodeURIComponent(idbh)+
                    '&funcionario='+encodeURIComponent(funcionario)
            })
            .then(response => response.text())
            .then(data => {
                if (data === "ok") {
                    location.reload();
                } else {
                    alert("Erro ao executar. Mensagem: "+data);
                }
            });
        }

        function detalheFunc(id) {
            fetch('scripts/ws_naveg_fdetalhe.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: 'id='+encodeURIComponent(id)
            })
            .then(response => response.text())
            .then(data => {
                if (data === "ok") {
                    window.location.href = "ws_bh_func_detalhe.php";
                } else {
                    alert("Atenção, Mensagem: " + data);
                }
            });
        }

        /* Na página destino do Fetch() anterior está o acionador da function a seguir */
        function voltarPagina(){
            location.reload();
        }
        function voltarPagina3() {
            window.location.href = "ws_bh.php";
        }
    </script>
    <?php
        include_once('scripts/ws_vbar.php');
        $tabela = 'banco_horas_func';
    ?>
    <div class="conteudo">
        <a href="ws_bh.php" class="nav-link"><h1>Bancos de Horas</a> > Funcionários</h1>
        <button type="button" onclick="includeRegistro('<?= $id_alfa?>','bancohora')" class="sub-content-include">
            <div class="content-include">
                <div class="img-include">
                    <span>Incluir Registros</span>
                </div>
            </div>
        </button><button type="button" onclick="creatorRegistro('<?= $id_alfa ?>')" class="sub-content-create2">
            <div class="content-create2">
                <div class="img-create2">
                    <span>Criar Registro</span>
                </div>
            </div>
        </button>
        <div class="content-table">
            <form name="form-us" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="POST">
                <table class="main-table" align="center">
                    <tr align="center" class="tr-cab">
                        <td class="td-cab"></td>
                        <td class="td-cab" style="padding:0px 120px;">FUNCIONÁRIO</td>
                        <td class="td-cab">SALDO INICIAL</td>
                        <td class="td-cab">JANEIRO</td>
                        <td class="td-cab">FEVEREIRO</td>
                        <td class="td-cab">MARÇO</td>
                        <td class="td-cab">ABRIL</td>
                        <td class="td-cab">MAIO</td>
                        <td class="td-cab">JUNHO</td>
                        <td class="td-cab">JULHO</td>
                        <td class="td-cab">AGOSTO</td>
                        <td class="td-cab">SETEMBRO</td>
                        <td class="td-cab">OUTUBRO</td>
                        <td class="td-cab">NOVEMBRO</td>
                        <td class="td-cab">DEZEMBRO</td>
                        <td class="td-cab">SALDO FINAL</td>
                        <td class="td-cab" style="padding:0px 100px;">LEGENDA</td>
                        <td colspan="2">AÇÕES</td>
                    </tr>
                    <?php
                    //BUSCA TODOS OS GRUPOS DE FUNCIONÁRIO ATIVOS E SOMENTE GRUPOS QUE ESTÃO NAS FOLHAS SELECIONADA
                    $sql_grupo = mysqli_query($conn,"SELECT
                                                        g.nome AS gnome, g.id AS grupoid
                                                     FROM 
                                                        grupo g,
                                                        banco_horas_func bhf,
                                                        funcionario f
                                                     WHERE
                                                        f.matr=bhf.fk_matr AND
                                                        g.id=f.fk_grupo AND
                                                        g.ativo=1 AND
                                                        f.ativo=1 AND
                                                        bhf.fk_banco_horas = $id_alfa AND
                                                        bhf.ativo=1
                                                     GROUP BY g.nome
                                                     ORDER BY g.nome ASC") or die(mysqli_error($conn));
                    
                    
                    while ($row_grupo = mysqli_fetch_assoc($sql_grupo)) {
                        $grupoid = $row_grupo['grupoid'];

                        //BUSCA AS INFORMAÇÕES DE BH POR CADA GRUPO
                        $sql_main = mysqli_query($conn,"SELECT
                                                        g.id AS gid, g.nome AS gnome,
                                                        f.nome AS fnome, f.matr AS fmatr,
                                                        bhf.fk_matr AS fk_matr
                                                    FROM 
                                                        grupo g,
                                                        banco_horas_func bhf,
                                                        funcionario f
                                                    WHERE
                                                        f.matr=bhf.fk_matr AND
                                                        g.id=f.fk_grupo AND
                                                        g.id=$grupoid AND
                                                        g.ativo=1 AND
                                                        f.ativo=1 AND
                                                        bhf.fk_banco_horas = $id_alfa AND
                                                        bhf.ativo=1
                                                    GROUP BY f.nome
                                                    ORDER BY g.nome ASC, f.nome ASC") or die(mysqli_error($conn));
                        while($row_main = mysqli_fetch_assoc($sql_main)) {
                            $grupo = $row_main['gid'];
                            $matr_temp = $row_main['fk_matr'];
                            ?>
                            <tr class="tr-cab">
                                <td class="td-cab"><?php echo $row_main['gnome'];?></td>
                                <td class="td-cab"><?php echo $row_main['fmatr']." - ".$row_main['fnome'];?></td>
                                <?php
                                //Consulta de do banco de horas de funcionário por meses
                                $sql_meses = mysqli_query($conn,"SELECT
                                                         	id, saldo, tipo_saldo
                                                         FROM 
                                                            banco_horas_func
                                                         WHERE
                                                         	ativo = 1 AND
                                                      		fk_matr = $matr_temp AND
                                                            fk_banco_horas = $id_alfa ") or die(mysqli_error($conn));
                                while($row_meses = mysqli_fetch_assoc($sql_meses)) {
                                    $id_bhf = $row_meses['id'];
                                    if ($row_meses['tipo_saldo'] == 1) {
                                        $hora1 += paraMinutos($row_meses['saldo']);?>
                                        <td style="color:skyblue;">
                                            <button type="button" onclick="detalheFunc('<?= $id_bhf ?>')" class="sub-link"><?= $row_meses['saldo']?></button>
                                        </td>
                                        <?php
                                    }elseif ($row_meses['tipo_saldo'] == 2) {
                                        $hora2 += paraMinutos($row_meses['saldo']);?>
                                        <td style="color:red;">
                                            <button type="button" onclick="detalheFunc('<?= $id_bhf ?>')" class="sub-link"><?= $row_meses['saldo']?></button>
                                        </td>
                                        <?php
                                    }else {
                                        $hora1 += 0;?>
                                        <td style="color:skyblue;">
                                            <button type="button" onclick="detalheFunc('<?= $id_bhf ?>')" class="sub-link"><?= $row_meses['saldo']?></button>
                                        </td>
                                        <?php
                                    }
                                    
                                }
                                if($hora2 > $hora1) {
                                    $saldo1 = $hora2 - $hora1;
                                    ?>
                                    <td style="color:red;"><?= paraDia($saldo1)?></td>
                                    <?php
                                }else {
                                    $saldo1 = $hora1 - $hora2;
                                    ?>
                                    <td style="color:skyblue;"><?= paraDia($saldo1)?></td>
                                    <?php
                                }
                                ?>
                                <td><?php echo tempoPorExtenso($saldo1);?><td>
                                <td class="td-icon">
                                    <a href="#" onclick="deleteRegistro('<?= $matr_temp ;?>','<?= $id_alfa ?>','<?php echo $tabela;?>')"><div class="img-del" data-tooltip="Deletar Registro"></div></a> 
                                </td>
                            </tr>
                            <?php
                            $hora1 = 0;
                            $hora2 = 0;
                            $saldo1 = 0;
                        }
                        ?>
                        <tr align="center" class="tr-divide" style="background-color:gray;">
                            <td class="td_divide" style="padding:0px 0px 25px 0px;" colspan="20"></td>
                        </tr>
                        <?php
                    }
                    ?>
                </table>
                <button type="button" onclick="voltarPagina3()" class="sub-content-back">
                    <div class="content-back">
                        <div class="img-back">
                            <span>Voltar</span>
                        </div>
                    </div>
                </button>
            </form>
        </div>
    </div>
    <div id="workInfor" class="workInfor"></div>
</body>
</html>