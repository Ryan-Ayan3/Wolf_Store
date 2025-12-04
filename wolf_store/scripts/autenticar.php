<?php
function acessoModulo($modulo, $conn) {
    $usuarioId = $_SESSION['usuarioId'];
    //global $conn; //Declarar como Global, pois o $conn não existe dentro da função, porque variáveis externas não entram automaticamente dentro de funções no PHP. Evitar erro de Warning: Undefined variable $conn

    $sqlPermissao = mysqli_query($conn,"SELECT 1
                                        FROM usuario u
                                        JOIN modulo_permissao mp ON mp.fk_nivel = u.fk_nivel
                                        AND mp.ativo = 1
                                        JOIN modulo m ON m.id = mp.fk_modulo
                                        AND m.ativo = 1
                                        WHERE u.id = $usuarioId AND m.nome = '$modulo'
                                        LIMIT 1");

    return mysqli_num_rows($sqlPermissao) > 0;
}

function moduloPermissao($modulo, $conn) {
    $usuarioId = $_SESSION['usuarioId'];

    $sqlValidar = mysqli_query($conn,"SELECT 1
                                        FROM usuario u
                                        JOIN modulo_permissao mp ON mp.fk_nivel = u.fk_nivel
                                        AND mp.ativo = 1
                                        JOIN modulo m ON m.id = mp.fk_modulo
                                        AND m.ativo = 1
                                        WHERE u.id = $usuarioId AND m.nome = '$modulo'
                                        LIMIT 1");

    return mysqli_num_rows($sqlValidar) > 0;
}

?>