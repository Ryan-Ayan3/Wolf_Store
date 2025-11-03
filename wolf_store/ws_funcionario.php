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
            fetch('ws_departamento_editor.php?id='+encodeURIComponent(id)+'&tabela='+encodeURIComponent(tabela))
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
                    fetch('scripts/ws_edit_departamento.php', {
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
                            window.location.href = "ws_departamento.php"
                        } else {
                            alert("Erro ao executar. Mensagem: "+data);
                        }
                    });
                }
            }

        function creatorRegistro() {
            fetch('ws_funcionario_add.php')
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

            fetch('scripts/ws_add_funcionario.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: 
                    'nome='+encodeURIComponent(nome)
            })
            .then(response => response.text())
            .then(data => {
                if (data === "ok") {
                    window.location.href = "ws_funcionario.php"
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
        $sql = mysqli_query($conn, "SELECT 
                                        f.id, f.matr, f.nome, f.fk_funcao, f.afastado, f.criado,
                                        d.nome AS dpnome,
                                        s.nome AS senome,
                                        ff.nome AS funome
                                    FROM funcionario f
                                    JOIN departamento d ON f.fk_departamento = d.id
                                    JOIN setor s ON f.fk_setor = s.id
                                    JOIN funcao ff ON f.fk_funcao = ff.id
                                    WHERE 
                                        f.ativo = 1
                                    ORDER BY f.nome ASC") or die(mysqli_error($conn));
        $tabela = 'funcionario';
    ?>
    <div class="conteudo">
        <h1>Funcionários</h1>
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
                                <td class="td-cab">Matrícula</td>
                                <td class="td-cab">Nome</td>
                                <td class="td-cab">Departamento</td>
                                <td class="td-cab">Setor</td>
                                <td class="td-cab">Função</td>
                                <td class="td-cab">Afastado</td>
                                <td class="td-cab">Registrado</td>
                                <td colspan="2">AÇÕES</td>
                            </tr>
                            <?php
                            while($row = mysqli_fetch_assoc($sql)) { 
                                if ($row['afastado'] == 1) {
                                    $afastado = "Sim";
                                } else {
                                    $afastado = "Não";
                                }
                                echo "
                                    <tr align='left' class='tr-main'>
                                        <td>".$row['id']."</td>
                                        <td>".$row['matr']."</td>
                                        <td>".$row['nome']."</td>
                                        <td>".$row['dpnome']."</td>
                                        <td>".$row['senome']."</td>
                                        <td>".$row['funome']."</td>
                                        <td>".$afastado."</td>
                                        <td>".$dataAlt = date("d/m/Y", strtotime($row['criado']));"</td>";?>
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