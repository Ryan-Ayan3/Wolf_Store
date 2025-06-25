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
            fetch('ws_cliente_editor.php?id='+encodeURIComponent(id)+'&tabela='+encodeURIComponent(tabela))
            .then(response => response.text())
            .then(html => {
                const container = document.getElementById('workInfor');
                container.innerHTML = html;
            });
            workInfor.style.display = 'block';
        }        
        function editRegistro(id,tabela) {
                const form = document.forms['form-us-edit'];
                const nome = form.nome.value;
                const cadastro = form.cadastro.value;
                const uf = form.uf.value;
                const cep = form.cep.value;
                const municipio = form.municipio.value;
                const bairro = form.bairro.value;
                const rua = form.rua.value;
                const endereco = form.endereco.value;
                const complemento = form.complemento.value;
                const contato = form.contato.value;
                const email = form.email.value;
                const obs = form.obs.value;

                if(confirm("Registrar alteração?")) {
                    fetch('scripts/ws_edit_cliente.php', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/x-www-form-urlencoded'
                        },
                        body:
                            'id='+encodeURIComponent(id)+
                            '&tabela='+encodeURIComponent(tabela)+
                            '&nome='+encodeURIComponent(nome)+
                            '&cadastro='+encodeURIComponent(cadastro)+
                            '&uf='+encodeURIComponent(uf)+
                            '&cep='+encodeURIComponent(cep)+
                            '&municipio='+encodeURIComponent(municipio)+
                            '&bairro='+encodeURIComponent(bairro)+
                            '&rua='+encodeURIComponent(rua)+
                            '&endereco='+encodeURIComponent(endereco)+
                            '&complemento='+encodeURIComponent(complemento)+
                            '&contato='+encodeURIComponent(contato)+
                            '&email='+encodeURIComponent(email)+
                            '&obs='+encodeURIComponent(obs)
                    })
                    .then(response => response.text())
                    .then(data => {
                        if (data === "ok") {
                            window.location.href = "ws_cliente.php"
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
                document.getElementById('busca').addEventListener('input', function () {
                    const termo = this.value;

                    if (termo.length < 1) {
                        document.getElementById('resultado').innerHTML = '';
                        return;
                    }

                    fetch('scripts/buscar.php?q=' + encodeURIComponent(termo))
                        .then(resp => resp.text())
                        .then(dados => {
                        document.getElementById('resultado').innerHTML = dados;
                        });
                });
                /* CLIQUE para selecionar registro */
                document.addEventListener('click', function(e) {
                if (e.target.classList.contains('item')) {
                    document.getElementById('busca').value = e.target.textContent;
                    document.getElementById('resultado').innerHTML = '';
                }
                });
            });
            workInfor.style.display = 'block';
        }

        function createRegistro() {
            const form = document.forms['form-us-create'];
            const nome = form.nome.value;
            const cadastro = form.cadastro.value;
            const uf = form.uf.value;
            const cep = form.cep.value;
            const municipio = form.municipio.value;
            const bairro = form.bairro.value;
            const rua = form.rua.value;
            const endereco = form.endereco.value;
            const complemento = form.complemento.value;
            const contato = form.contato.value;
            const email = form.email.value;
            const obs = form.obs.value;

            fetch('scripts/ws_add_produto.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: 
                    'nome='+encodeURIComponent(nome)+
                    '&cadastro='+encodeURIComponent(cadastro)+
                    '&uf='+encodeURIComponent(uf)+
                    '&cep='+encodeURIComponent(cep)+
                    '&municipio='+encodeURIComponent(municipio)+
                    '&bairro='+encodeURIComponent(bairro)+
                    '&rua='+encodeURIComponent(rua)+
                    '&endereco='+encodeURIComponent(endereco)+
                    '&complemento='+encodeURIComponent(complemento)+
                    '&contato='+encodeURIComponent(contato)+
                    '&email='+encodeURIComponent(email)+
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

        /* SCRIPT de busca dinâmica */
        
    </script>
    <?php
        include_once('scripts/ws_vbar.html');
        $sql = mysqli_query($conn, "SELECT id, codg, nome, tipo_fkey,medida_fkey FROM produto WHERE ativo=1") or die(mysqli_error($conn));
        $tabela = 'produto';
    ?>
    <div class="conteudo">
        <h1>Produtos</h1>
        <div class="content-create">
            <a href="#" onclick="creatorRegistro()">
                <div class="img-create"><span>Criar Registro</span></div>
            </a>
        </div> 
        <div class="ws_user">
            <form name="form-us" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="POST">
                <table class="main-table" align="center">
                    <tr align="center" class="tr-cab">
                        <td class="td-cab">ID</td>
                        <td class="td-cab">Código</td>
                        <td class="td-cab">Nome</td>
                        <td class="td-cab">Tipo de Produto</td>
                        <td class="td-cab">Unidade de Medida</td>
                        <td colspan="2">AÇÕES</td>
                    </tr>
                    <?php
                        if (mysqli_num_rows($sql) <= 15) {
                            while($row = mysqli_fetch_assoc($sql)) { 
                                $tipo = $row['tipo_fkey'];
                                $medida = $row['medida_fkey'];
                                $sql_tipo = mysqli_query($conn, "SELECT nome FROM produto WHERE ativo=1 and id=$tipo") or die(mysqli_error($conn));
                                $row_tipo = mysqli_fetch_assoc($sql_tipo);
                                $sql_medida = mysqli_query($conn, "SELECT nome FROM medida WHERE ativo=1 and id=$medida") or die(mysqli_error($conn));
                                $row_medida = mysqli_fetch_assoc($sql_medida);
                                echo "
                                    <tr align='left' class='tr-main'>
                                        <td>".$row['id']."</td>
                                        <td>".$row['codg']."</td>
                                        <td>".$row['nome']."</td>
                                        <td>".$row_tipo['nome']."</td>
                                        <td>".$row_medida['nome']."</td>";?>
                                        <td class="td-icon">
                                            <a href="#" onclick="editorRegistro('<?php echo $row['id'];?>','<?php echo $tabela;?>')"><div class="img-edit"></div></a>
                                        </td>
                                        <td class="td-icon">
                                            <a href="#" onclick="deleteRegistro('<?php echo $row['id'];?>','<?php echo $tabela;?>')"><div class="img-del"></div></a> 
                                        </td>
                                        <?php echo "
                                    </tr>";
                            }
                        }
                    ?>
                </table>
            </form>
        </div>
    </div>
    <div id="workInfor" class="workInfor"></div>
</body>
</html>