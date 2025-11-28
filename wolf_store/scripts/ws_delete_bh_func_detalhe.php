<?php
    require_once('../conn/conn.php');
    include_once('ws_time.php');
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $id_del = intval($_POST['id']); //Conversor para tipo INT. Medida de segurança
        $tabela_del = preg_replace('/[^a-zA-Z0-9_]/', '', $_POST['tabela']); //Sanitização para permisão somente de letras, números e underline. Medida de segurança
        $idf = intval($_POST['idf']);

        //Consultar Saldo total para soma
        $sql_bh = mysqli_query($conn, "SELECT id, tipo_saldo, saldo FROM banco_horas_func WHERE ativo=1 AND id=$idf") or die(mysqli_error($conn));
        $row_bh = mysqli_fetch_assoc($sql_bh);

        //Consultar para estornar valor da exclusão
        $sql_bhd = mysqli_query($conn, "SELECT
                                            bhd.id, bhd.valor AS valorbhd, e.id as ide
                                        FROM
                                            banco_horas_func_detalhe bhd,
                                            evento e
                                        WHERE
                                            bhd.ativo=1 AND
                                            bhd.id=$id_del AND
                                            e.id = bhd.fk_evento") or die(mysqli_error($conn));
        $row_bhd = mysqli_fetch_assoc($sql_bhd);

        // Converte saldo para segundos com sinal
        $saldo = paraMinutos($row_bh['saldo']);
        $saldo = ($row_bh['tipo_saldo'] == 1) ? $saldo : -$saldo;

        // Estornar tempo anterior para $saldo
        $tempoAnt = paraMinutos($row_bhd['valorbhd']);
        $tempoAnt = ($row_bhd['ide'] == 1) ? -$tempoAnt : $tempoAnt;
        $saldo = $saldo + $tempoAnt;

        // Resultado com estorno e soma do novo tempo
        $saldof = $saldo;

        // Determina o tipo do resultado do saldo
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
        $saldof = paraDia($saldof);

        // Deletar detalhe
        $sql3 = mysqli_query($conn,"UPDATE $tabela_del SET ativo=0,deletado='$dt_hr' WHERE id=$id_del") or die(mysqli_error($conn));

        // Atualizar saldo
        $sql2 = mysqli_query($conn,"UPDATE banco_horas_func
                                        SET 
                                            saldo='$saldof',
                                            tipo_saldo='$ts'
                                        WHERE id=$idf") or die(mysqli_error($conn));

        $sql_dell = mysqli_query($conn, "UPDATE $tabela_del SET ativo=0,deletado='$dt_hr' WHERE id=$id_del") or die(mysqli_error($conn));
        
        echo "ok";
      
    }
?>