<?php
namespace Entities\Services;

// ADICIONAR: Requires necessários
require_once __DIR__ . '/../pessoa/pessoa.php';
require_once __DIR__ . '/ServicoInterface.php';

// ADICIONAR: Use statements
use Entities\Pessoa\Pessoa;

class Restaurante implements ServicoInterface {
    
    public function calcularPreco(Pessoa $hospede): float {
        return $hospede->getTipo() === "Juridica" ? 80 : 70;
    }
    
    public function getDescricao(): string {
        return "Serviço de Restaurante";
    }
    
    // Métodos específicos do restaurante
    public function fazerReserva(Pessoa $cliente, $dataHora, $numeroPessoas) {
        return "Reserva feita para " . $cliente->getNome() . 
               " em " . $dataHora . " para " . $numeroPessoas . " pessoas";
    }
    
    public function cardapioDoDia(): array {
        return [
            "Entrada" => "Salada Caesar",
            "Prato Principal" => "Salmão Grelhado",
            "Sobremesa" => "Mousse de Chocolate"
        ];
    }
}