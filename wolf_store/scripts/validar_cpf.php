<?php
    $cpf = $cadastro;
    $cpf = preg_replace('/[^0-9]/', '', $cpf);

    if (strlen($cpf) != 11 || preg_match('/(\d)\1{10}/', $cpf)) {
        echo "CPF inválido\n";
        $validado = 0;
    } else {
        $validado = 1;

        for ($t = 9; $t < 11; $t++) {
            $soma = 0;
            for ($i = 0; $i < $t; $i++) {
                $soma += $cpf[$i] * (($t + 1) - $i);
            }
            $digito = ((10 * $soma) % 11) % 10;
            if ($cpf[$t] != $digito) {
                $validado = 0;
                break;
            }
        }
        $result1 = $cpf;
    }
?>