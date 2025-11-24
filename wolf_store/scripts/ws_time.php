<?php
    //CONVERSOR DE TIME HH:MM:SS PARA SOMA
    $hora1 = 0; //HORA POSITIVA
    $hora2 = 0; //HORA NEGATIVA
    $saldo1= 0;
    function paraSegundos($time) {
            list($h, $m, $s) = explode(':', $time);
            return $h * 3600 + $m * 60 + $s;
        }

    function paraHora($segundos) {
        $h = floor($segundos / 3600);
        $segundos %= 3600;
        $m = floor($segundos / 60);
        $s = $segundos % 60;

        return sprintf('%02d:%02d:%02d', $h, $m, $s);
    }

    //VALIDA FORMATO DE HORA PARA >0:<60:<60
    function validarHora($hora) {
        // Verifica formato HH:MM:SS (apenas formato)
        if (!preg_match('/^\d{2}:\d{2}:\d{2}$/', $hora)) {
            return false; // formato inválido
        }

        list($h, $m, $s) = explode(':', $hora);

        // Converte para inteiro
        $h = intval($h);
        $m = intval($m);
        $s = intval($s);

        // Valida limites
        if ($m < 0 || $m > 59) return false;
        if ($s < 0 || $s > 59) return false;

        return true; // tudo OK
    }
?>