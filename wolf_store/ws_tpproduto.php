<?php
    require_once('scripts/ws_credencial.php');
    include_once('scripts/ws_logoff.php');
    require_once('conn/conn.php');
    require_once('scripts/autenticar.php');

    if (!moduloPermissao('Tipos de Produtos', $conn)) {
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
                        alert("Erro ao excluir. Mensagem: "+data);
                    }
                });
            }
        } 

        function editorRegistro(id,tabela) {
            fetch('ws_tpproduto_editor.php?id='+encodeURIComponent(id)+'&tabela='+encodeURIComponent(tabela))
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
                    fetch('scripts/ws_edit_tpproduto.php', {
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
                            window.location.href = "ws_tpproduto.php"
                        } else {
                            alert("Erro ao executar. Mensagem:"+data);
                        }
                    });
                }
            }


        function creatorRegistro() {
            fetch('ws_tpproduto_add.php')
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
            const nome = form.nome.value;

            fetch('scripts/ws_add_tpproduto.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: 'nome='+encodeURIComponent(nome)
            })
            .then(response => response.text())
            .then(data => {
                if (data === "ok") {
                    window.location.href = "ws_tpproduto.php"
                } else {
                    alert("Erro ao executar. Mensagem:"+data);
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
        $tabela = 'tipo_produto';

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

        $sql = mysqli_query($conn, "SELECT id, nome FROM $tabela WHERE ativo=1 LIMIT $registrosPorPagina OFFSET $offset") or die(mysqli_error($conn));
        
    ?>
    <div class="conteudo">
        <h1>Tipos de Produtos</h1>
        <div class="content-create">
            <a href="#" onclick="creatorRegistro('<?php echo $tabela;?>')">
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
                                <td colspan="2">AÇÕES</td>
                            </tr>
                            <?php
                            while($row = mysqli_fetch_assoc($sql)) { 
                                echo "
                                    <tr align='left' class='tr-main'>
                                        <td align='center'>".$row['id']."</td>
                                        <td align='left'>".$row['nome']."</td>";?>
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
            </form>
        </div>
    </div>
    <div id="workInfor" class="workInfor"></div>
</body>
</html>