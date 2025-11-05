<?php

    

    require_once('../conn/conn.php');
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $matricula = trim(mysqli_real_escape_string($conn,$_POST['matricula']));
        $nome = trim(mysqli_real_escape_string($conn,$_POST['nome']));
        $dp = trim(mysqli_real_escape_string($conn,$_POST['dp']));

        if ($dp == 0) {
                echo "Departamento precisa ser informado!";
                exit;
        }
        $setor = trim(mysqli_real_escape_string($conn,$_POST['setor']));
        $funcao = trim(mysqli_real_escape_string($conn,$_POST['funcao']));
        $grupo = trim(mysqli_real_escape_string($conn,$_POST['grupo']));
        $salario = trim(mysqli_real_escape_string($conn,$_POST['salario']));
        $afastado = trim(mysqli_real_escape_string($conn,$_POST['afastado']));
        
        $sql = mysqli_query($conn, "INSERT INTO funcionario(
                                                    matr,
                                                    nome,
                                                    fk_departamento,
                                                    fk_setor,
                                                    fk_funcao,
                                                    fk_grupo,
                                                    salario,
                                                    afastado,
                                                    criado, 
                                                    ativo) 
                                                VALUES(
                                                    '$matricula',
                                                    '$nome',
                                                    '$dp',
                                                    '$setor',
                                                    '$funcao',
                                                    '$grupo',
                                                    '$salario',
                                                    '$afastado',
                                                    '$dt_hr',
                                                    1)") or die(mysqli_error($conn));

        echo "ok";
    }
?>