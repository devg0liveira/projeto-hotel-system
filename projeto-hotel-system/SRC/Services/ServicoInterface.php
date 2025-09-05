<?php
namespace Entities\Services;

// ADICIONAR: Require da classe Pessoa
require_once __DIR__ . '/../pessoa/pessoa.php';

// ADICIONAR: Use statement
use Entities\Pessoa\Pessoa;

interface ServicoInterface {
    public function calcularPreco(Pessoa $hospede): float;
    public function getDescricao(): string;
}