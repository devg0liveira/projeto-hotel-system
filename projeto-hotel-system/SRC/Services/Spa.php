<?php
namespace Entities\Services;

use Entities\Pessoa\Pessoa;

class Spa implements ServicoInterface {
    public function calcularPreco(Pessoa $hospede): float {
        return $hospede->getTipo() === "Juridica" ? 120 : 100;
    }

    public function getDescricao(): string {
        return "SPA Relaxante";
    }
}
