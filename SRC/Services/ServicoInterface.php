<?php
namespace Hotel\Services;

use Hotel\Models\Abstract\Pessoa;

interface ServicoInterface {
    public function calcularPreco(Pessoa $hospede): float;
    public function getDescricao(): string;
}
