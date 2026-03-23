<?php

class Validator
{
    /**
     * Valida matematicamente um CPF brasileiro.
     * Retorna true se for válido, false se for inválido.
     */
    public static function isCpfValid($cpf)
    {
        // Extrai somente os números
        $cpf = preg_replace('/[^0-9]/is', '', $cpf);

        // Verifica se tem 11 dígitos exatos
        if (strlen($cpf) != 11) {
            return false;
        }

        // Verifica sequências inválidas conhecidas (ex: 111.111.111-11)
        if (preg_match('/(\d)\1{10}/', $cpf)) {
            return false;
        }

        // Faz o cálculo matemático para validar os 2 dígitos verificadores finais
        for ($t = 9; $t < 11; $t++) {
            for ($d = 0, $c = 0; $c < $t; $c++) {
                $d += $cpf[$c] * (($t + 1) - $c);
            }
            $d = ((10 * $d) % 11) % 10;
            if ($cpf[$c] != $d) {
                return false;
            }
        }

        return true;
    }
}