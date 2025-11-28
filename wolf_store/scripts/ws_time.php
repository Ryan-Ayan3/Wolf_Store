<?php
    //CONVERSOR DE TIME HH:MM:SS PARA SOMA
    $hora1 = 0; //HORA POSITIVA
    $hora2 = 0; //HORA NEGATIVA
    $saldo1= 0;
    function paraMinutos($time) {
            list($d, $h, $m) = explode(':', $time);
            return $d * 528 + $h * 60 + $m;
        }

    function paraDia($minutos) {
        $d = floor($minutos / 528);
        $minutos %= 528;
        $h = floor($minutos / 60);
        $m = $minutos % 60;

        return sprintf('%02d:%02d:%02d', $d, $h, $m);
    }

    //VALIDA FORMATO DE HORA PARA >0:<60:<60
    function validarTempo($tempo) {
        // Verifica formato HH:MM:SS (apenas formato)
        if (!preg_match('/^\d{2}:\d{2}:\d{2}$/', $tempo)) {
            return false; // formato inválido
        }

        list($d, $h, $m) = explode(':', $tempo);

        // Converte para inteiro
        $d = intval($d);
        $h = intval($h);
        $m = intval($m);

        // Valida limites
        if ($h < 0 || $h > 23) return false;
        if ($m < 0 || $m > 59) return false;
        //if ($h >= 8 && $m >= 48) return false;

        return true; // tudo OK
    }

    /*
    Preciso de um SCRIPT especial aonde ele pegará uma Variável com valor de tempo e preciso que seja impresso em texto por extenso o valor em Dias, Horas e Minutos.
Ex: 01:20:25 para ser escrito por extenso como: Um dia, vinte horas e vinte e cinco minutos.

Porém é necessário que seja considerado o seguinte. 1 Dia é igual à 8horas e 48minutos, 1hora igual à 60minutos como o normal e minuto é minuto.

A variável que receberá para entrar nesse script em tempo e sair em texto eu consigo enviar tanto como "dd:hh:mm / 01:20:25" como tudo em minuto(Ex: ) já convertido. Escolha qual valor de variável ficaria melhor já para evitar linhas extras de códigos. O código deve ser todo em PHP, eu já tenho duas function paraMinutos() que recebe no formato dd:hh:mm e devolve em minutos e tenho a function paraDia() que recebe em minutos e devolve em dd:hh:mm
    */
?>