<?php
    require_once('scripts/ws_credencial.php');
    include_once('scripts/ws_logoff.php');
    require_once('conn/conn.php');

    if (!isset($_SESSION['id_fdetalhe'])) {
        echo "<script>alert('Acesso inválido ou tempo expirado.'); window.history.back();";
        exit;
    }
    $fdetalhe = (int) $_SESSION['id_fdetalhe'];
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
        function deleteRegistro(id,tabela) {
            if(confirm("Deletar registro?")) {
                fetch('scripts/ws_delete.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: 'id='+encodeURIComponent(id)+'&tabela='+encodeURIComponent(tabela)
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

        function editorRegistro(id,tabela) {
            fetch('ws_funcao_editor.php?id='+encodeURIComponent(id)+'&tabela='+encodeURIComponent(tabela))
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

                /* Click fora do MODAL para voltar */
                const modal = document.getElementById('main-table-form');
                const div1 = document.getElementById('div-us-edit');
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
        function editRegistro(id,tabela) {
                const form = document.forms['form-us-edit'];
                const nome = form.nome.value;

                if(confirm("Registrar alteração?")) {
                    fetch('scripts/ws_edit_funcao.php', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/x-www-form-urlencoded'
                        },
                        body:
                            'id='+encodeURIComponent(id)+
                            '&tabela='+encodeURIComponent(tabela)+
                            '&nome='+encodeURIComponent(nome)
                    })
                    .then(response => response.text())
                    .then(data => {
                        if (data === "ok") {
                            window.location.href = "ws_funcao.php"
                        } else {
                            alert("Erro ao executar. Mensagem: "+data);
                        }
                    });
                }
            }

        function creatorRegistro(idf) {
            fetch('ws_bh_func_detalhe_add.php?idf='+encodeURIComponent(idf))
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

        function createRegistro() {
            const form = document.forms['form-us-create'];
            const idf = form.idf.value;
            const evento = form.evento.value;
            const valor = form.valor.value;
            const obs = form.obs.value;

            fetch('scripts/ws_add_bh_funca_detalhe.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: 
                    'idf='+encodeURIComponent(idf)+'&evento='+encodeURIComponent(evento)+'&valor='+encodeURIComponent(valor)+'&obs='+encodeURIComponent(obs)
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

        /* Na página destino do Fetch() anterior está o acionador da function a seguir */
        function voltarPagina(){
            location.reload();
        }
        function voltar1(){
            window.history.back();
        }
        function voltar2(){
            location.href = "ws_bh_func.php";
        }
    </script>
    <?php
        include_once('scripts/ws_vbar.html');
        $tabela = 'banco_horas_func_detalhe';
        $sql = mysqli_query($conn, "SELECT id,fk_evento,valor,obs,criado FROM $tabela WHERE ativo=1 AND fk_banco_horas_func=$fdetalhe") or die(mysqli_error($conn));
    ?>
    <div class="conteudo">
        <a href="ws_bh.php" class="nav-link"><h1>Bancos de Horas</a> > <a href="#" onclick="voltar2()" class="nav-link">Funcionários</a> > Detalhe</h1>
        <div class="content-create">
            <a href="#" onclick="creatorRegistro('<?= $fdetalhe ?>')">
                <div class="img-create"><span>Criar Registro</span></div>
            </a>
        </div> 
        <div class="content-table">
            <form name="form-us" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="POST">
                <table class="main-table" align="center">
                    <?php
                        if (mysqli_num_rows($sql) > 0) {
                            ?>
                            <tr align="center" class="tr-cab">
                                <td class="td-cab">Evento</td>
                                <td class="td-cab">Valor</td>
                                <td class="td-cab">Registrado</td>
                                <td class="td-cab">Obs</td>
                                <td colspan="2">AÇÕES</td>
                            </tr>
                            <?php
                            while($row = mysqli_fetch_assoc($sql)) {
                                $fkevento = $row['fk_evento'];
                                $sql_evento = mysqli_query($conn, "SELECT nome, tipo_saldo FROM evento WHERE ativo=1 AND (funcao=2 OR funcao=3) AND id=$fkevento") or die(mysqli_error($conn));
                                $row_evento = mysqli_fetch_assoc($sql_evento);
                                echo "
                                    <tr align='left' class='tr-main'>
                                        <td align='center'>".$row_evento['nome']."</td>
                                        <td align='center'>".$row['valor']."</td>
                                        <td align='center'>".$dataAlt = date("d/m/Y", strtotime($row['criado']));"</td>";?>
                                        <td><?= $row['obs']?></td>
                                        <td class="td-icon">
                                            
                                            <a href="#" onclick="editorRegistro('<?php echo $row['id'];?>','<?php echo $tabela;?>')"><div class="img-edit" data-tooltip="Editar Registro"></div></a>
                                        </td>
                                        <td class="td-icon">
                                            <a href="#" onclick="deleteRegistro('<?php echo $row['id'];?>','<?php echo $tabela;?>')"><div class="img-del" data-tooltip="Deletar Registro"></div></a> 
                                        </td>
                                        <?php echo "
                                    </tr>";
                            }
                        } else {
                            include_once('scripts/mensagem_nodata.html');
                        }
                    ?>
                </table>
            </form>
        </div>
    </div>
    <div id="workInfor" class="workInfor"></div>
</body>
</html>