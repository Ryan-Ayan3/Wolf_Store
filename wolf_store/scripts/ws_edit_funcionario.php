<?php
    require_once('../conn/conn.php');
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $id_edit2 = intval($_POST['id']); //Conversor para tipo INT. Medida de segurança
        $tabela_edit2 = preg_replace('/[^a-zA-Z0-9_]/', '', $_POST['tabela']); //Sanitização para permisão somente de letras, números e underline. Medida de segurança
        $matricula = trim(mysqli_real_escape_string($conn,$_POST['matricula']));
        $sql_temp = mysqli_query($conn, "SELECT * FROM funcionario WHERE ativo=1 AND matr=$matricula AND NOT id=$id_edit2") or die(mysqli_error($conn));
        if (mysqli_num_rows($sql_temp) > 0) {
            echo "Já existe um funcionário com essa matrícula";
            exit;
        }

        $nome = trim(mysqli_real_escape_string($conn,$_POST['nome']));
        $dp = trim(mysqli_real_escape_string($conn,$_POST['dp']));
        $setor = trim(mysqli_real_escape_string($conn,$_POST['setor']));
        $funcao = trim(mysqli_real_escape_string($conn,$_POST['funcao']));
        $grupo = trim(mysqli_real_escape_string($conn,$_POST['grupo']));
        $salario = trim(mysqli_real_escape_string($conn,str_replace(',', '.', $_POST['salario'])));
        $afastado = trim(mysqli_real_escape_string($conn,$_POST['afastado']));
        $alterar_f = $dt_hr;
        
        $sql3 = mysqli_query($conn,"UPDATE $tabela_edit2 
                                        SET 
                                            matr='$matricula',
                                            nome='$nome',
                                            fk_departamento='$dp',
                                            fk_setor='$setor',
                                            fk_funcao='$funcao',
                                            fk_grupo='$grupo',
                                            salario='$salario',
                                            afastado='$afastado',
                                            alterado='$alterar_f' 
                                        WHERE id=$id_edit2") or die(mysqli_error($conn));
        
        echo "ok";
    }
?>