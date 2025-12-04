<script>
    function togglevbar(event) {
        event.preventDefault();
        var item = event.target.closest('.submenu');
        item.classList.toggle('open');
    }
</script>
<div class="vbar">
    <h2><a href="ws_home.php" class="menu"><img src="imgs/wolf_store_logo.jpg" height="30px" width="30px">Wolf Store</a></h2>
    <ul>
        <?php if (acessoModulo('Aquisições', $conn)) { ?>
        <li class="submenu">
            <a href="" onclick="togglevbar(event)" class="legenda"><img src="icons/add1.png" height="22px" width="22px">Aquisições</a>
            <ul class="op-com">
                <?php if (acessoModulo('Produto', $conn)) { ?>
                    <li><a href="ws_produto.php">Produto</a></li>
                <?php } if (acessoModulo('Fornecedor', $conn)) { ?>
                    <li><a href="ws_fornecedor.php">Fornecedor</a></li>
                <?php } if (acessoModulo('Aquisição de Produto', $conn)) { ?>
                    <li><a href="ws_aquisicao.php">Aquisição de Produto</a></li>
                <?php } if (acessoModulo('Solicitação de Aquisição', $conn)) { ?>
                    <li><a href="#">Solicitação de Aquisição #</a></li>
                <?php } ?>
            </ul>
        </li>
        <?php } if (acessoModulo('Estoque', $conn)) { ?>
        <li class="submenu">
            <a href="" onclick="togglevbar(event)" class="legenda"><img src="icons/estoque1.png" height="22px" width="22px">Estoque</a>
            <ul class="op-com">
                <?php if (acessoModulo('Posição de Estoque', $conn)) { ?>
                    <li><a href="#">Posição de Estoque #</a></li>
                <?php } if (acessoModulo('Analisar Estoque', $conn)) { ?>
                    <li><a href="#">Analisar Estoque #</a></li>    
                <?php } if (acessoModulo('Inventário', $conn)) { ?>
                    <li><a href="#">Inventário #</a></li>
                <?php } if (acessoModulo('Entrada Livre', $conn)) { ?>
                    <li><a href="#">Entrada Livre #</a></li>
                <?php } if (acessoModulo('Saída Livre', $conn)) { ?>
                    <li><a href="#">Saída Livre #</a></li>
                <?php } ?>
            </ul>
        </li>
        <?php } if (acessoModulo('Comercial', $conn)) { ?>
        <li class="submenu">
            <a href="" onclick="togglevbar(event)" class="legenda"><img src="icons/moeda1.png" height="22px" width="22px">Comercial</a>
            <ul class="op-com">
                <?php if (acessoModulo('Cliente', $conn)) { ?>
                    <li><a href="ws_cliente.php">Cliente</a></li>
                <?php } if (acessoModulo('Venda', $conn)) { ?>
                    <li><a href="#">Venda #</a></li>
                <?php } ?>
            </ul>
        </li>
        <?php } if (acessoModulo('Gestão Pessoal', $conn)) { ?>
        <li class="submenu">
            <a href="" onclick="togglevbar(event)" class="legenda"><img src="icons/pessoal1.png" height="22px" width="22px">Gestão Pessoal</a>
            <ul class="op-com">
                <?php if (acessoModulo('Funcionário', $conn)) { ?>
                    <li><a href="ws_funcionario.php">Funcionário</a></li>
                <?php } if (acessoModulo('Folha', $conn)) { ?>
                    <li><a href="#">Folha #</a></li>
                <?php } if (acessoModulo('Adiatamento', $conn)) { ?>
                    <li><a href="#">Adiatamento #</a></li>
                <?php } if (acessoModulo('Décimo Terceiro', $conn)) { ?>
                    <li><a href="#">Décimo Terceiro #</a></li>
                <?php } if (acessoModulo('Resumo', $conn)) { ?>
                    <li><a href="#">Resumo #</a></li>
                <?php } if (acessoModulo('Banco de Horas', $conn)) { ?>
                    <li><a href="ws_bh.php">Banco de Horas</a></li>
                <?php } if (acessoModulo('Gerir Eventos da Folha & BH', $conn)) { ?>
                    <li><a href="ws_evento.php">Gerir Eventos da Folha & BH</a></li>
                <?php } if (acessoModulo('Gerir Setor', $conn)) { ?>
                    <li><a href="ws_setor.php">Gerir Setor</a></li>
                <?php } if (acessoModulo('Gerir Departamento', $conn)) { ?>
                    <li><a href="ws_departamento.php">Gerir Departamento</a></li>
                <?php } if (acessoModulo('Gerir Função', $conn)) { ?>
                    <li><a href="ws_funcao.php">Gerir Função</a></li>
                <?php } if (acessoModulo('Gerir Grupo', $conn)) { ?>
                    <li><a href="ws_grupo.php">Gerir Grupo</a></li>
                <?php } ?>
            </ul>
        </li>
        <?php } if (acessoModulo('Sistema', $conn)) { ?>
        <li class="submenu">
            <a href="" onclick="togglevbar(event)" class="legenda"><img src="icons/config1.png" height="22px" width="22px">Sistema</a>
            <ul class="op-com">
                <?php if (acessoModulo('Usuário', $conn)) { ?>
                    <li><a href="ws_users.php">Usuário</a></li>
                <?php } if (acessoModulo('Nível', $conn)) { ?>
                    <li><a href="ws_nivel.php">Nível</a></li>
                <?php } if (acessoModulo('Módulo', $conn)) { ?>
                    <li><a href="#">Módulo #</a></li>
                <?php } if (acessoModulo('Tipos de Movimentação', $conn)) { ?>
                    <li><a href="ws_movimento.php">Tipos de Movimentação</a></li>
                <?php } if (acessoModulo('Unidades de Medidas', $conn)) { ?>
                    <li><a href="ws_medidas.php">Unidades de Medidas</a></li>
                <?php } if (acessoModulo('Tipos de Produtos', $conn)) { ?>
                    <li><a href="ws_tpproduto.php">Tipos de Produtos</a></li>
                <?php } ?>
            </ul>
        </li>
        <?php } ?>
        <li class="submenu">
            <form method="POST"><input type="submit" class="sub-exit" name="sair" value="Sair"></form>
        </li>
    </ul>
</div>
<div class="bg-conteudo"></div>