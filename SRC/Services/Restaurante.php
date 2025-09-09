<?php
namespace Hotel\Services;

use Hotel\Models\Abstract\Pessoa;

class Restaurante implements ServicoInterface {
    public function calcularPreco(Pessoa $hospede): float {
        return $hospede->getTipo() === "Juridica" ? 90.00 : 75.00;
    }
    
    public function getDescricao(): string {
        return "Restaurante Gourmet";
    }
}