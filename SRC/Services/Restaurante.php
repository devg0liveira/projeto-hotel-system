<?php
namespace Hotel\Services;

use Hotel\Services\ServicoInterface;
use Hotel\Models\Abstract\Pessoa;

class Restaurante implements ServicoInterface
{
    private string $tipo;

    public function __construct(string $tipo)
    {
        $this->tipo = $tipo;
    }

    public function calcularPreco(Pessoa $hospede): float
    {
        return match($this->tipo) {
            'cafe' => 20.0,
            'almoco' => 30.0,
            'jantar' => 30.0,
            default => 0.0,
        };
    }

    public function getDescricao(): string
    {
        return ucfirst($this->tipo);
    }
}
