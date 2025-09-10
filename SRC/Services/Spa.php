<?php
namespace Hotel\Services;

use Hotel\Models\Abstract\Pessoa;

class Spa implements ServicoInterface {
    public function calcularPreco(Pessoa $hospede): float {
        return $hospede->getTipo() === "Juridica" ?: 100.00;
    }
    
    public function getDescricao(): string {
        return "SPA Relaxante";
    }
}
