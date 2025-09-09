<?php

namespace Hotel\Models\Pessoas;

use Hotel\Models\Abstract\Pessoa;

class PessoaFisica extends Pessoa
{

    public function getTipo()
    {
        return "Fisica";
    }

    public function getTaxaAdicional()
    {
        return 0.0;
    }
}
