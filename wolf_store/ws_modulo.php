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
            fetch('ws_modulo_editor.php?id='+encodeURIComponent(id)+'&tabela='+encodeURIComponent(tabela))
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
                document.querySelectorAll("input[name='ePai']").forEach(radio => {
                    radio.addEventListener("change", function () {
                        const selectModulo = document.getElementById("sl-modulo");
                        const mark = document.getElementById("mark");
                        if (this.value == "1") {
                            // Resetar para "SELECIONE MÓDULO"
                            selectModulo.value = "0";
                            // Ocultar
                            selectModulo.style.display = "none";
                            // Impedir envio no POST
                            selectModulo.disabled = true;

                            //
                            mark.value = "A1";
                        } else {
                            // Mostrar novamente
                            selectModulo.style.display = "inline-block";
                            // Permitir envio no POST
                            selectModulo.disabled = false;

                            mark.value = "A2";
                        }
                    });
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
                const matricula = form.matricula.value.padStart(6, '0');
                const nome = form.nome.value;
                const dp = form.dp.value;
                const setor = form.setor.value;
                const funcao = form.funcao.value;
                const grupo = form.grupo.value;
                const salario = form.salario.value;
                const afastado = form.afastado.value;

                if(confirm("Registrar alteração?")) {
                    fetch('scripts/ws_edit_modulo.php', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/x-www-form-urlencoded'
                        },
                        body:
                            'id='+encodeURIComponent(id)+
                            '&tabela='+encodeURIComponent(tabela)+
                            '&matricula='+encodeURIComponent(matricula)+
                            '&nome='+encodeURIComponent(nome)+
                            '&dp='+encodeURIComponent(dp)+
                            '&setor='+encodeURIComponent(setor)+
                            '&funcao='+encodeURIComponent(funcao)+
                            '&grupo='+encodeURIComponent(grupo)+
                            '&salario='+encodeURIComponent(salario)+
                            '&afastado='+encodeURIComponent(afastado)
                    })
                    .then(response => response.text())
                    .then(data => {
                        if (data === "ok") {
                            window.location.href = "ws_modulo.php"
                        } else {
                            alert("Erro ao executar. Mensagem: "+data);
                        }
                    });
                }
            }

        function creatorRegistro() {
            fetch('ws_modulo_add.php')
            .then(response => response.text())
            .then(html => {
                const container = document.getElementById('workInfor');
                container.innerHTML = html;
                // Script para desconsiderar SELECT quando Checkbox estiver marcado
                document.querySelectorAll("input[name='ePai']").forEach(radio => {
                    radio.addEventListener("change", function () {
                        const selectModulo = document.getElementById("sl-modulo");
                        const mark = document.getElementById("mark");
                        if (this.value == "1") {
                            // Resetar para "SELECIONE MÓDULO"
                            selectModulo.value = "0";
                            // Ocultar
                            selectModulo.style.display = "none";
                            // Impedir envio no POST
                            selectModulo.disabled = true;

                            //
                            mark.value = "A1";
                        } else {
                            // Mostrar novamente
                            selectModulo.style.display = "inline-block";
                            // Permitir envio no POST
                            selectModulo.disabled = false;

                            mark.value = "A2";
                        }
                    });
                });
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
            const nome = form.nome.value;
            const modulo = form.modulo.value;
            const ePai = form.ePai.value;
            const mark = form.mark.value;

            fetch('scripts/ws_add_modulo.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: 
                    'nome='+encodeURIComponent(nome)+
                    '&modulo='+encodeURIComponent(modulo)+
                    '&ePai='+encodeURIComponent(ePai)+
                    '&mark='+encodeURIComponent(mark)
            })
            .then(response => response.text())
            .then(data => {
                if (data === "ok") {
                    window.location.href = "ws_modulo.php"
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
        $tabela = 'modulo';
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

        $sql = mysqli_query($conn, "SELECT id,nome,id_pai,criado
                                    FROM $tabela 
                                    WHERE ativo = 1
                                    ORDER BY id_pai ASC, id ASC
                                    LIMIT $registrosPorPagina OFFSET $offset") or die(mysqli_error($conn));


        ?>
    <div class="conteudo">
        <h1>Módulos</h1>
        <div class="content-create">
            <a href="#" onclick="creatorRegistro()">
                <div class="img-create"><span>Criar Registro</span></div>
            </a>
        </div> 
        <div class="content-table">
            <form name="form-us" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="POST">
                <table class="main-table" align="center">
                    <?php
                    if ($total > 0) {
                        ?>
                        <tr align="center" class="tr-cab">
                            <td class="td-cab">ID</td>
                            <td class="td-cab">Nome</td>
                            <td class="td-cab">Módulo Pai</td>
                            <td class="td-cab">Registrado</td>
                            <td colspan="2">AÇÕES</td>
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
                                <tr align='center' class='tr-main'>
                                    <td align='center'>".$row['id']."</td>
                                    <td align='left'>".$row['nome']."</td>
                                    <td align='left'>".$moduloPai."</td>
                                    <td align='center'>".$dataAlt = date("d/m/Y", strtotime($row['criado']));"</td>";?>
                                    <td class="td-icon" align="center">
                                        <a href="#" onclick="editorRegistro('<?php echo $row['id'];?>','<?php echo $tabela;?>')"><div class="img-edit" data-tooltip="Editar Registro"></div></a>
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