<?php
namespace Entities\Services;

use Entities\Pessoa\Pessoa;

class Estacionamento implements ServicoInterface {
    public function calcularPreco(Pessoa $hospede): float {
        return $hospede->getTipo() === "Juridica" ? 60 : 50;
    }

    public function getDescricao(): string {
        return "Serviço de Estacionamento";
    }
}
