<?php
    require_once('../conn/conn.php');
    include_once('ws_time.php');
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $idf = trim(mysqli_real_escape_string($conn,$_POST['idf']));
        $evento = trim(mysqli_real_escape_string($conn,$_POST['evento']));

        if ($evento == 0) {
            echo "Selecione um Evento";
            exit;
        }

        $valor = trim(mysqli_real_escape_string($conn,$_POST['valor']));
        $obs = trim(mysqli_real_escape_string($conn,$_POST['obs']));

        $sql_bh = mysqli_query($conn, "SELECT id, tipo_saldo, saldo FROM banco_horas_func WHERE ativo=1 AND id=$idf") or die(mysqli_error($conn));
        $row_bh = mysqli_fetch_assoc($sql_bh);

        $sql_evento = mysqli_query($conn, "SELECT id, funcao FROM evento WHERE id='$evento' AND ativo=1") or die(mysqli_error($conn));
        $row_evento = mysqli_fetch_assoc($sql_evento);

        /*
        120(NEGATIVO)

        60(POSITIVO)
        */
        //SALDO TOTAL FUNCIONARIO NO MÊS É NEGATIVO
        if ($row_bh['tipo_saldo'] == 2) {
            $saldo = paraSegundos($row_bh['tipo_saldo']);
            //VALOR A SOMAR É POSITIVO
            if ($row_evento['funcao'] == 1) {
                $tempo = paraSegundos($valor);
                //RESULTADO 
                if ($saldo >= $tempo) {
                    $saldo -= $tempo;
                    $resultado = "neg";
                } else {
                    $tempo -= $saldo;
                    $resultado = "pos";
                }
            //VALOR A SOMAR É NEGATIVO
            } else {
                $tempo = paraSegundos($row_evento['funcao']);
                //RESULTADO 
                $saldo += $tempo;
                $resultado = "neg";
            }
        //SALDO TOTAL FUNCIONARIO NO MÊS É POSITIVO
        } else {
            $saldo = paraSegundos($row_bh['tipo_saldo']);
            //VALOR A SOMAR É NEGATIVO
            if ($row_evento['funcao'] == 2) {
                $tempo = paraSegundos($row_evento['funcao']);
                //RESULTADO 
                if ($saldo >= $tempo) {
                    $saldo -= $tempo;
                    $resultado = "pos";
                } else {
                    $tempo -= $saldo;
                    $resultado = "neg";
                }
            //VALOR A SOMAR É POSITIVO
            } else {
                $tempo = paraSegundos($row_evento['funcao']);
                //RESULTADO 
                $saldo += $tempo;
                $resultado = "pos";
            }
        }


        /*$sql = mysqli_query($conn, "INSERT INTO banco_horas_func_detalhe(
                                                    fk_banco_horas_func,
                                                    fk_evento,
                                                    valor,
                                                    obs,
                                                    criado, 
                                                    ativo) 
                                                VALUES(
                                                    '$idf',
                                                    '$evento',
                                                    '$valor',
                                                    '$obs',
                                                    '$dt_hr',
                                                    1)") or die(mysqli_error($conn));

        echo "ok";*/
        echo $saldo." - ".$tempo." - ".$resultado;
    }
?>