<?php
namespace HotelSystem\Entities\Services;



// ADICIONAR: Use statement
use Entities\Pessoa\Pessoa;
use HotelSystem\Entities\Pessoa\Pessoa as PessoaPessoa;

interface ServicoInterface {
    public function calcularPreco(PessoaPessoa $hospede): float;
    public function getDescricao(): string;
}