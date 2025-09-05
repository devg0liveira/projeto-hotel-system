<?php
namespace HotelSystem\Entities\Services;

use Entities\Pessoa\Pessoa;
use HotelSystem\Entities\Pessoa\Pessoa as PessoaPessoa;

class Estacionamento implements ServicoInterface {
    public function calcularPreco(PessoaPessoa $hospede): float {
        return $hospede->getTipo() === "Juridica" ? 60 : 50;
    }

    public function getDescricao(): string {
        return "Serviço de Estacionamento";
    }
}
