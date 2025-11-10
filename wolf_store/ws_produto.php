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
            fetch('ws_produto_editor.php?id='+encodeURIComponent(id)+'&tabela='+encodeURIComponent(tabela))
            .then(response => response.text())
            .then(html => {
                const container = document.getElementById('workInfor');
                container.innerHTML = html;
                /* BUSCA Registro através de Input */
                document.getElementById('pesquisador').addEventListener('input', function () {
                    const intel = this.value;

                    if (intel.length < 1) {
                        document.getElementById('busca').innerHTML = '';
                        return;
                    }

                    fetch('scripts/buscar_fornecedor.php?i=' + encodeURIComponent(intel))
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
                        document.getElementById('fornecedor_in').value = in2;
                        document.getElementById('busca').innerHTML = '';
                    }
                });
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
                const codigo = form.codigo.value;
                const nome = form.nome.value;
                const medida = form.medida.value;
                const tipo = form.tipo.value;
                const peso = form.peso.value;
                const preco = form.preco.value;
                const fornecedor = form.fornecedor_in.value;
                const obs = form.obs.value;

                if(confirm("Registrar alteração?")) {
                    fetch('scripts/ws_edit_produto.php', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/x-www-form-urlencoded'
                        },
                        body:
                            'id='+encodeURIComponent(id)+
                            '&tabela='+encodeURIComponent(tabela)+
                            '&codigo='+encodeURIComponent(codigo)+ 
                            '&nome='+encodeURIComponent(nome)+
                            '&medida='+encodeURIComponent(medida)+
                            '&tipo='+encodeURIComponent(tipo)+
                            '&peso='+encodeURIComponent(peso)+
                            '&preco='+encodeURIComponent(preco)+
                            '&fornecedor='+encodeURIComponent(fornecedor)+
                            '&obs='+encodeURIComponent(obs)
                    })
                    .then(response => response.text())
                    .then(data => {
                        if (data === "ok") {
                            window.location.href = "ws_produto.php"
                        } else {
                            alert("Erro ao executar. Mensagem: "+data);
                        }
                    });
                }
            }

        function creatorRegistro() {
            fetch('ws_produto_add.php')
            .then(response => response.text())
            .then(html => {
                const container = document.getElementById('workInfor');
                container.innerHTML = html;
                /* BUSCA Registro através de Input */
                document.getElementById('pesquisador').addEventListener('input', function () {
                    const intel = this.value;

                    if (intel.length < 1) {
                        document.getElementById('busca').innerHTML = '';
                        return;
                    }

                    fetch('scripts/buscar_fornecedor.php?i=' + encodeURIComponent(intel))
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
                        document.getElementById('fornecedor_in').value = in2;
                        document.getElementById('busca').innerHTML = '';
                    }
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
            const codigo = form.codigo.value;
            const nome = form.nome.value;
            const medida = form.medida.value;
            const tipo = form.tipo.value;
            const peso = form.peso.value;
            const preco = form.preco.value;
            const fornecedor = form.fornecedor_in.value;
            const obs = form.obs.value;

            fetch('scripts/ws_add_produto.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body:
                    'codigo='+encodeURIComponent(codigo)+ 
                    '&nome='+encodeURIComponent(nome)+
                    '&medida='+encodeURIComponent(medida)+
                    '&tipo='+encodeURIComponent(tipo)+
                    '&peso='+encodeURIComponent(peso)+
                    '&preco='+encodeURIComponent(preco)+
                    '&fornecedor='+encodeURIComponent(fornecedor)+
                    '&obs='+encodeURIComponent(obs)
            })
            .then(response => response.text())
            .then(data => {
                if (data === "ok") {
                    window.location.href = "ws_produto.php"
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
        include_once('scripts/ws_vbar.html');
        $sql = mysqli_query($conn, "SELECT id, codg, nome, tipo, medida FROM produto WHERE ativo=1") or die(mysqli_error($conn));
        $tabela = 'produto';
    ?>
    <div class="conteudo">
        <h1>Produtos</h1>
        <div class="content-create">
            <a href="#" onclick="creatorRegistro()">
                <div class="img-create"><span>Criar Registro</span></div>
            </a>
        </div> 
        <div class="content-table">
            <form name="form-us" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="POST">
                <table class="main-table" align="center">
                    <?php
                        if (mysqli_num_rows($sql) <= 15 && mysqli_num_rows($sql) > 0) {
                            ?>
                            <tr align="center" class="tr-cab">
                                <td class="td-cab">ID</td>
                                <td class="td-cab">Código</td>
                                <td class="td-cab">Nome</td>
                                <td class="td-cab">Tipo de Produto</td>
                                <td class="td-cab">Unidade de Medida</td>
                                <td colspan="2">AÇÕES</td>
                            </tr>
                            <?php
                            while($row = mysqli_fetch_assoc($sql)) { 
                                $tipo = $row['tipo'];
                                $medida = $row['medida'];
                                $sql_tipo = mysqli_query($conn, "SELECT nome FROM tipo_produto WHERE ativo=1 and id=$tipo") or die(mysqli_error($conn));
                                $row_tipo = mysqli_fetch_assoc($sql_tipo);
                                $sql_medida = mysqli_query($conn, "SELECT nome FROM unidade_medida WHERE ativo=1 and id=$medida") or die(mysqli_error($conn));
                                $row_medida = mysqli_fetch_assoc($sql_medida);
                                echo "
                                    <tr align='left' class='tr-main'>
                                        <td align='center'>".$row['id']."</td>
                                        <td align='center'>".$row['codg']."</td>
                                        <td>".$row['nome']."</td>
                                        <td align='center'>".$row_tipo['nome']."</td>
                                        <td align='center'>".$row_medida['nome']."</td>";?>
                                        <td class="td-icon">
                                            <a href="#" onclick="editorRegistro('<?php echo $row['id'];?>','<?php echo $tabela;?>')"><div class="img-edit"></div></a>
                                        </td>
                                        <td class="td-icon">
                                            <a href="#" onclick="deleteRegistro('<?php echo $row['id'];?>','<?php echo $tabela;?>')"><div class="img-del"></div></a> 
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