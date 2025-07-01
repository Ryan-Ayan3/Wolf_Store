<?php
    require_once('../conn/conn.php');
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $id_edit2 = intval($_POST['id']); //Conversor para tipo INT. Medida de segurança
        $tabela_edit2 = preg_replace('/[^a-zA-Z0-9_]/', '', $_POST['tabela']); //Sanitização para permisão somente de letras, números e underline. Medida de segurança
        $codigo = trim(mysqli_real_escape_string($conn,$_POST['codigo']));
        $nome = trim(mysqli_real_escape_string($conn,$_POST['nome']));
        $medida = trim(mysqli_real_escape_string($conn,$_POST['medida']));
        $tipo = trim(mysqli_real_escape_string($conn,$_POST['tipo']));
        $peso = trim(mysqli_real_escape_string($conn,$_POST['peso']));
        $preco = trim(mysqli_real_escape_string($conn,$_POST['preco']));
        $fornecedor = trim(mysqli_real_escape_string($conn,$_POST['fornecedor']));
        $obs = trim(mysqli_real_escape_string($conn,$_POST['obs']));
        $alterar_f = $dt_hr;
        
        if($fornecedor == "") {
            $sql = mysqli_query($conn, "UPDATE $tabela_edit2 
                                        SET 
                                            codg='$codigo',
                                            nome='$nome',
                                            medida='$medida',
                                            tipo='$tipo',
                                            peso='$peso',
                                            preco='$preco',
                                            fornecedor=NULL,
                                            obs='$obs',
                                            alterado='$alterar_f' 
                                        WHERE id=$id_edit2") or die(mysqli_error($conn));

        } elseif($fornecedor != "" && $fornecedor > 0) {
            $sql = mysqli_query($conn, "UPDATE $tabela_edit2 
                                        SET 
                                            codg='$codigo',
                                            nome='$nome',
                                            medida='$medida',
                                            tipo='$tipo',
                                            peso='$peso',
                                            preco='$preco',
                                            fornecedor='$fornecedor',
                                            obs='$obs',
                                            alterado='$alterar_f' 
                                        WHERE id=$id_edit2") or die(mysqli_error($conn));
            
        } else {
            echo "Selecione apenas fornecedores já registrado.";
            exit;
        }
    }
    echo "ok";
?>