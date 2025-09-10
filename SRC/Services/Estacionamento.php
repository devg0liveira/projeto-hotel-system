<?php
namespace Hotel\Services;

use Hotel\Models\Abstract\Pessoa;

class Estacionamento implements ServicoInterface {
    public function calcularPreco(Pessoa $hospede): float {
        return $hospede->getTipo() === "Juridica" ? : 30.00;
    }
    
    public function getDescricao(): string {
        return "Estacionamento VIP";
    }
}