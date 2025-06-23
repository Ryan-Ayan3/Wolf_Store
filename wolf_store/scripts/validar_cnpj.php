<?php
    $cnpj = $cadastro;
    if (strlen($cnpj) != 14 || preg_match('/(\d)\1{13}/', $cnpj)) {
        $validado = 0;
    } else {
        $peso1 = [5, 4, 3, 2, 9, 8, 7, 6, 5, 4, 3, 2];
        $peso2 = [6, 5, 4, 3, 2, 9, 8, 7, 6, 5, 4, 3, 2];

        $soma = 0;
        for ($i = 0; $i < 12; $i++) {
            $soma += $cnpj[$i] * $peso1[$i];
        }
        $dig1 = ($soma % 11 < 2) ? 0 : 11 - ($soma % 11);

        $soma = 0;
        for ($i = 0; $i < 13; $i++) {
            $soma += $cnpj[$i] * $peso2[$i];
        }
        $dig2 = ($soma % 11 < 2) ? 0 : 11 - ($soma % 11);

        if ($cnpj[12] == $dig1 && $cnpj[13] == $dig2) {
            $validado = 1;
        } else {
            $validado = 0;
        }
        $result1 = $cnpj;
    }
?>