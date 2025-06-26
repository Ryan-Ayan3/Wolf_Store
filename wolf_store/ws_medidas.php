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
                        alert("Erro ao excluir. Mensagem: "+data);
                    }
                });
            }
        } 

        function editorRegistro(id,tabela) {
            fetch('ws_medidas_editor.php?id='+encodeURIComponent(id)+'&tabela='+encodeURIComponent(tabela))
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
                const tipoValor = form.tipoValor.value;

                if(confirm("Registrar alteração?")) {
                    fetch('scripts/ws_edit_medidas.php', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/x-www-form-urlencoded'
                        },
                        body: 
                            'id='+encodeURIComponent(id)+
                            '&tabela='+encodeURIComponent(tabela)+
                            '&nome='+encodeURIComponent(nome)+
                            '&tipoValor='+encodeURIComponent(tipoValor)
                    })
                    .then(response => response.text())
                    .then(data => {
                        if (data === "ok") {
                            window.location.href = "ws_medidas.php"
                        } else {
                            alert("Erro ao executar. Mensagem:"+data);
                        }
                    });
                }
            }


        function creatorRegistro() {
            fetch('ws_medidas_add.php')
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
            const tipoValor = form.tipoValor.value;

            fetch('scripts/ws_add_medidas.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: 
                    'nome='+encodeURIComponent(nome)+
                    '&tipoValor='+encodeURIComponent(tipoValor)
            })
            .then(response => response.text())
            .then(data => {
                if (data === "ok") {
                    window.location.href = "ws_medidas.php"
                } else {
                    alert("Erro ao executar. Mensagem:"+tipoValor+data);
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
        $sql = mysqli_query($conn, "SELECT id, nome, tipoValor FROM unidade_medida WHERE ativo=1") or die(mysqli_error($conn));
        $tabela = 'unidade_medida';
    ?>
    <div class="conteudo">
        <h1>Unidades de Medidas</h1>
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
                        <td class="td-cab">Nome</td>
                        <td class="td-cab">Tipo de Valor</td>
                        <td colspan="2">AÇÕES</td>
                    </tr>
                    <?php
                        if (mysqli_num_rows($sql) <= 10) {
                            while($row = mysqli_fetch_assoc($sql)) {
                                if($row['tipoValor'] == 1) {
                                    $tipoValor = "Inteiro";
                                } elseif($row['tipoValor'] == 2) {
                                    $tipoValor = "Decimal";
                                } else {
                                    $tipoValor = "NO DATA";
                                }
                                echo "
                                    <tr align='left' class='tr-main'>
                                        <td>".$row['id']."</td>
                                        <td>".$row['nome']."</td>
                                        <td>".$tipoValor."</td>";?>
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