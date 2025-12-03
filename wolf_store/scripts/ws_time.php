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
        //if ($h < 0 || $h > 23) return false;
        if ($m < 0 || $m > 59) return false;
        //if ($h >= 8 && $m >= 48) return false;

        return true; // tudo OK
    }

    function tempoPorExtenso($minutosTotal) {

        // 1 DIA = 8h48 = 528 minutos
        $dias = floor($minutosTotal / 528);
        $minutosTotal %= 528;

        // horas comuns
        $horas = floor($minutosTotal / 60);
        $minutos = $minutosTotal % 60;

        // Função interna para escrever números por extenso
        $numeros = [
            0=>"zero",1=>"um",2=>"dois",3=>"três",4=>"quatro",5=>"cinco",6=>"seis",7=>"sete",8=>"oito",9=>"nove",
            10=>"dez",11=>"onze",12=>"doze",13=>"treze",14=>"quatorze",15=>"quinze",
            16=>"dezesseis",17=>"dezessete",18=>"dezoito",19=>"dezenove",
            20=>"vinte",30=>"trinta",40=>"quarenta",50=>"cinquenta"
        ];

        // Converte número para texto até 59
        $toText = function($n) use ($numeros) {
            if ($n <= 20 || $n % 10 == 0) return $numeros[$n];
            $dezena = floor($n / 10) * 10;
            $unidade = $n % 10;
            return $numeros[$dezena] . " e " . $numeros[$unidade];
        };

        // Montagem do texto final
        $partes = [];

        if ($dias > 0) {
            $partes[] = $toText($dias) . " " . ($dias == 1 ? "dia" : "dias");
        }
        if ($horas > 0) {
            $partes[] = $toText($horas) . " " . ($horas == 1 ? "hora" : "horas");
        }
        if ($minutos > 0) {
            $partes[] = $toText($minutos) . " " . ($minutos == 1 ? "minuto" : "minutos");
        }

        // Caso seja zero de tudo
        if (empty($partes)) return "zero minutos";

        // Junta com vírgulas e “e” no final
        $ultimo = array_pop($partes);
        if (empty($partes)) return $ultimo;
        return implode(", ", $partes) . " e " . $ultimo;
    }
?>