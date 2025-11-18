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
?>