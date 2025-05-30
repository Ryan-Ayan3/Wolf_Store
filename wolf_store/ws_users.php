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
                fetch('scripts/ws.delete.php', {
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

        function editRegistro(id,tabela) {
            fetch('ws_users_edit.php?id=' + encodeURIComponent(id))
            .then(response => response.text())
            .then(html => {
                 const container = document.getElementById('area-formulario');
                container.innerHTML = html;
            });
        }
    </script>
    <?php
        include_once('scripts/ws_vbar.html');
        $sql = mysqli_query($conn, "SELECT id, login, nivel, cargo, nome FROM usuario WHERE ativo=1") or die(mysqli_error($conn));
        $tabela = 'usuario';
    ?>
    <div class="conteudo">
        <h1>USUÁRIOS</h1>
        <div class="ws_user">
            <form name="form-us" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="POST">
                <table class="main-table" align="center" border="1">
                    <tr align="center" class="tr-cab">
                        <td class="td-cab">Código</td>
                        <td class="td-cab">Login</td>
                        <td class="td-cab">Nível</td>
                        <td class="td-cab">Cargo</td>
                        <td class="td-cab">Nome</td>
                        <td colspan="2">AÇÕES</td>
                    </tr>
                    <?php
                        if (mysqli_num_rows($sql) <= 10) {
                            while($row = mysqli_fetch_assoc($sql)) { 
                                echo "
                                    <tr align='left' class='tr-main'>
                                        <td>".$row['id']."</td>
                                        <td>".$row['login']."</td>
                                        <td>".$row['nivel']."</td>
                                        <td>".$row['cargo']."</td>
                                        <td>".$row['nome']."</td>";?>
                                        <td>
                                            <a href="#" onclick="editRegistro('<?php echo $row['id'];?>','<?php echo $tabela;?>')"><div class="img-edit"></div></a>
                                        </td>
                                        <td>
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
</body>
</html>