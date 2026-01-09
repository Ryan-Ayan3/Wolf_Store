<?php
    require_once('scripts/ws_credencial.php');
    include_once('scripts/ws_logoff.php');
    require_once('conn/conn.php');
    require_once('scripts/autenticar.php');

    if (!moduloPermissao('Banco de Horas', $conn)) {
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
        function deleteRegistro(id,tabela) {
            if(confirm("Deletar registro?")) {
                fetch('scripts/ws_delete_bh.php', {
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
                    }else if(data === "Token expirado" || data === "Procedimento Inválido"){
                        alert('Token expirado');
                        window.history.back();
                    }
                    else {
                        alert("Atenção, erro: " + data);
                    }
                });
            }
        }

        function acessarRegistro(token, id) {
            fetch('scripts/ws_validacao_bh.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: 'token='+encodeURIComponent(token)+'&id='+encodeURIComponent(id)
            })
            .then(response => response.text())
            .then(data => {
                if (data === "ok") {
                    window.location.href = "ws_bh_func.php";
                } else {
                    alert("Atenção, Mensagem: " + data);
                }
            });
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

        function editorRegistro(id,tabela) {
            fetch('ws_bh_editor.php?id='+encodeURIComponent(id)+'&tabela='+encodeURIComponent(tabela))
            .then(response => response.text())
            .then(html => {
                const container = document.getElementById('workInfor');
                container.innerHTML = html;
                document.body.style.overflow = 'hidden';
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
                const ano = form.ano.value;

                if(confirm("Registrar alteração?")) {
                    fetch('scripts/ws_edit_bh.php', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/x-www-form-urlencoded'
                        },
                        body:
                            'id='+encodeURIComponent(id)+
                            '&tabela='+encodeURIComponent(tabela)+
                            '&ano='+encodeURIComponent(ano)
                    })
                    .then(response => response.text())
                    .then(data => {
                        if (data === "ok") {
                            window.location.href = "ws_bh.php";
                        } else {
                            alert("Erro ao executar. Mensagem: "+data);
                        }
                    });
                }
            }

        function creatorRegistro() {
            fetch('ws_bh_add.php')
            .then(response => response.text())
            .then(html => {
                const container = document.getElementById('workInfor');
                container.innerHTML = html;
                document.body.style.overflow = 'hidden';
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
            const ano = form.ano.value;

            fetch('scripts/ws_add_bh.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: 
                    'ano='+encodeURIComponent(ano)
            })
            .then(response => response.text())
            .then(data => {
                if (data === "ok") {
                    window.location.href = "ws_bh.php"
                } else {
                    alert("Erro ao executar. Mensagem: "+data);
                }
            });
        }

        /* Na página destino do Fetch() anterior está o acionador da function a seguir */
        function voltarPagina(){
            location.reload();
        }
    </script>
    <?php
        include_once('scripts/ws_vbar.php');
        $tabela = 'banco_horas';
        $registrosPorPagina = 10;
        // Página atual
        $pagina = isset($_GET['pagina']) ? intval($_GET['pagina']) : 1;
        if ($pagina < 1) $pagina = 1;

        // Calcular o offset
        $offset = ($pagina - 1) * $registrosPorPagina;

        // Quantidade total de registros
        $totalSql = mysqli_query($conn, "SELECT COUNT(*) AS total FROM $tabela WHERE ativo = 1");
        $total = mysqli_fetch_assoc($totalSql)['total'];

        // Total de páginas
        $totalPaginas = ceil($total / $registrosPorPagina);
        $sql = mysqli_query($conn, "SELECT id, ano, encerrado FROM $tabela WHERE ativo=1 ORDER BY ano DESC LIMIT $registrosPorPagina OFFSET $offset") or die(mysqli_error($conn));

    ?>
    <div class="conteudo">
        <ul class="breadcrumb">
            <li><a href="#" onclick="voltarPagina()"><span class="icon-start"></span>Bancos de Horas</a></li>
        </ul>
        <div class="content-create">
            <a href="#" onclick="creatorRegistro()">
                <div class="img-create"><span>Criar Registro</span></div>
            </a>
        </div> 
        <div class="content-table">
            <form name="form-us">
                <table class="main-table-compact" align="center">
                    <?php
                        if ($total > 0) {
                            ?>
                            <tr align="center" class="tr-cab">
                                <td class="td-cab">Ano</td>
                                <td class="td-cab">Encerrado</td>
                                <td colspan="3">AÇÕES</td>
                            </tr>
                            <?php
                            while($row = mysqli_fetch_assoc($sql)) {
                                $encerrado = $row['encerrado'] == 0 ? "Não" : "Sim";
                                $token = bin2hex(random_bytes(16));
                                $_SESSION['tokens'][$token] = ['id' => $row['id'], 'time' => time()];
                                
                                echo "
                                    <tr align='center' class='tr-main'>
                                        <td>";?>
                                            <button type="button" onclick="acessarRegistro('<?php echo $token; ?>','<?php $_SESSION['tokens']; ?>')" class="sub-link"><?= $row['ano']?></button>
                                        <?php echo "</td>
                                        <td>".$encerrado."</td>";?>
                                        <td class="td-icon" align="center">
                                            <a href="#" alt="incluir" onclick="includeRegistro('<?= $row['id']?>','bancohora')"><div class="img-inclu" data-tooltip="Incluir Funcionários"></div></a>
                                        </td>
                                        <td class="td-icon" align="center">
                                            <a href="#" alt="editar" onclick="editorRegistro('<?php echo $row['id'];?>','<?php echo $tabela;?>')"><div class="img-edit" data-tooltip="Editar Registro"></div></a>
                                        </td>
                                        <td class="td-icon" align="center">
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
                <?php if ($totalPaginas > 1) { ?>
                        <div class="paginacao">
                        <!-- Página anterior -->
                        <?php if ($pagina > 1) { ?>
                            <a href="?pagina=<?php echo $pagina - 1; ?>">&laquo; Anterior</a>
                        <?php } ?>
                        <!-- Números das páginas -->
                        <?php for ($i = 1; $i <= $totalPaginas; $i++) { ?>
                            <a href="?pagina=<?php echo $i; ?>"
                            class="<?php echo ($i == $pagina) ? 'ativo' : ''; ?>">
                                <?php echo $i; ?>
                            </a>
                        <?php } ?>
                        <!-- Próxima página -->
                        <?php if ($pagina < $totalPaginas) { ?>
                            <a href="?pagina=<?php echo $pagina + 1; ?>">Próxima &raquo;</a>
                        <?php } ?>
                    </div>
                    <?php } ?>
            </form>
        </div>
    </div>
    <div id="workInfor" class="workInfor"></div>
</body>
</html>