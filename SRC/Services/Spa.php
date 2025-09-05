<?php
namespace HotelSystem\Entities\Services;

use Entities\Pessoa\Pessoa;
use HotelSystem\Entities\Pessoa\Pessoa as PessoaPessoa;

class Spa implements ServicoInterface {
    public function calcularPreco(PessoaPessoa $hospede): float {
        return $hospede->getTipo() === "Juridica" ? 120 : 100;
    }

    public function getDescricao(): string {
        return "SPA Relaxante";
    }
}
