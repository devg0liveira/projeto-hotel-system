<?php
namespace Entities\Quarto;

class Simples extends Quarto
{
    public function getDescricao()
    {
        return "Quarto Simples - Numero: {$this->numero}, Preço: {$this->preco}";
    }

    public function reservar()
    {
        if ($this->disponivel) {
            $this->disponivel = false;
            return true;
        }
        return false;
    }
}
