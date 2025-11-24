<?php
    require_once('../conn/conn.php');
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $id_edit2 = intval($_POST['id']); //Conversor para tipo INT. Medida de segurança
        $tabela_edit2 = preg_replace('/[^a-zA-Z0-9_]/', '', $_POST['tabela']); //Sanitização para permisão somente de letras, números e underline. Medida de segurança
        $alterar_f = $dt_hr;
        $idf = trim(mysqli_real_escape_string($conn,$_POST['idf']));
        $evento = trim(mysqli_real_escape_string($conn,$_POST['evento']));
        $valor = trim(mysqli_real_escape_string($conn,$_POST['valor']));

        if (!validarHora($valor)) {
            echo "Formato de hora inválido. Minutos e Segundos não podem ser igual ou maior que 60";
            exit;
        }

        $obs = trim(mysqli_real_escape_string($conn,$_POST['obs']));

        $sql_bh = mysqli_query($conn, "SELECT id, tipo_saldo, saldo FROM banco_horas_func WHERE ativo=1 AND id=$idf") or die(mysqli_error($conn));
        $row_bh = mysqli_fetch_assoc($sql_bh);

        $sql_bhd = mysqli_query($conn, "SELECT
                                            bhd.id, bhd.valor AS valorbhd, e.id as ide
                                        FROM
                                            banco_horas_func_detalhe bhd,
                                            evento e
                                        WHERE
                                            bhd.ativo=1 AND
                                            bhd.id=$id_edit2 AND
                                            e.id = bhd.fk_evento") or die(mysqli_error($conn));
        $row_bhd = mysqli_fetch_assoc($sql_bhd);

        $sql_evento = mysqli_query($conn, "SELECT id, tipo_saldo FROM evento WHERE id='$evento' AND ativo=1") or die(mysqli_error($conn));
        $row_evento = mysqli_fetch_assoc($sql_evento);

        // Converte saldo para segundos com sinal
        $saldo = paraSegundos($row_bh['saldo']);
        $saldo = ($row_bh['tipo_saldo'] == 1) ? $saldo : -$saldo;

        $tempoAnt = ($row_bhd['valor']);
        $tempoAnt = ($row_bhd['ide'] == 1) ? -$tempoAnt : $tempoAnt;
        // Estornar tempo anterior para saldo
        $saldo = $saldo + $tempoAnt;

        // Converte tempo para segundos com sinal
        $tempoNv = ($row_evento['tipo_saldo'] == 1) ? $tempo : -$tempo;

        // Resultado
        $saldof = $saldo + $tempoNv;

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

        $alterar_f = $dt_hr;
        
        $sql3 = mysqli_query($conn,"UPDATE $tabela_edit2 
                                        SET 
                                            fk_evento='$evento',
                                            valor='$tempoNv',
                                            obs='$obs',
                                            alterado='$alterar_f' 
                                        WHERE id=$id_edit2") or die(mysqli_error($conn));
        
        echo "ok";
    }
?>