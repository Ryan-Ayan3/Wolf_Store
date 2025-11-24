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

        if (!validarHora($valor)) {
            echo "Formato de hora inválido. Minutos e Segundos não podem ser igual ou maior que 60";
            exit;
        }

        $obs = trim(mysqli_real_escape_string($conn,$_POST['obs']));

        $sql_bh = mysqli_query($conn, "SELECT id, tipo_saldo, saldo FROM banco_horas_func WHERE ativo=1 AND id=$idf") or die(mysqli_error($conn));
        $row_bh = mysqli_fetch_assoc($sql_bh);

        $sql_evento = mysqli_query($conn, "SELECT id, tipo_saldo FROM evento WHERE id='$evento' AND ativo=1") or die(mysqli_error($conn));
        $row_evento = mysqli_fetch_assoc($sql_evento);

        /*
        120(NEGATIVO)

        60(POSITIVO)
        */
        // Converte saldo para segundos com sinal
        $saldo = paraSegundos($row_bh['saldo']);
        $saldo = ($row_bh['tipo_saldo'] == 1) ? $saldo : -$saldo;

        // Converte tempo para segundos com sinal
        $tempo = paraSegundos($valor);
        $tempo = ($row_evento['tipo_saldo'] == 1) ? $tempo : -$tempo;

        // Resultado
        $saldof = $saldo + $tempo;

        // Determina o tipo do resultado
        if ($saldof > 0) {
            $resultado = "pos";
            $ts = 1;
        } elseif ($saldof < 0) {
            $resultado = "neg";
            $ts = 2;
        } else {
            $resultado = "zero";
            $ts = 0;
        }

        // Remover sinal negativo se tiver, medida de segurança.
        $saldof = abs($saldof);
        $tempo = abs($tempo);
        $saldof = paraHora($saldof);
        $tempo = paraHora($tempo);

        $sql = mysqli_query($conn, "INSERT INTO banco_horas_func_detalhe(
                                                    fk_banco_horas_func,
                                                    fk_evento,
                                                    valor,
                                                    obs,
                                                    criado, 
                                                    ativo) 
                                                VALUES(
                                                    '$idf',
                                                    '$evento',
                                                    '$tempo',
                                                    '$obs',
                                                    '$dt_hr',
                                                    1)") or die(mysqli_error($conn));
        $sql = mysqli_query($conn, "UPDATE banco_horas_func SET saldo='$saldof', tipo_saldo='$ts' WHERE ativo=1 AND id=$idf ") or die(mysqli_error($conn));

        echo "ok";
        //echo "Saldo Anterior: ".paraHora($saldo)."| - Valor Novo: ".$tempo."| Saldo Final: ".$saldof."/".$resultado;
    }
?>