<?php

    require_once('../conn/conn.php');
    $id_del = intval($_POST['id']); //Conversor para tipo INT. Medida de segurança
    $tabela_del = preg_replace('/[^a-zA-Z0-9_]/', '', $_POST['tabela']); //Sanitização para permisão somente de letras, números e underline. Medida de segurança

    $sql_dell = mysqli_query($conn, "UPDATE $tabela_del SET ativo=0 WHERE id=$id_del") or die(mysqli_error($conn));

    echo "ok";

/*
    TAG gatilho para ativação
    <a href="#" onclick="deleteRegistro('<?php echo $row['id'];?>','<?php echo $tabela;?>')"><div class="img-del"></div></a>

    JAVASCRIPT para executar ação de 'exclusão'.
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
    </script>
*/
    
?>