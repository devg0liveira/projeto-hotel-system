<?php
namespace Hotel\Services;

use Hotel\Models\Abstract\Pessoa;

class Estacionamento implements ServicoInterface {
    public function calcularPreco(Pessoa $hospede): float {
        // Preço fixo para todos os tipos de hóspede
        return 30.00;
    }
    
    public function getDescricao(): string {
        return "Estacionamento VIP";
    }
}