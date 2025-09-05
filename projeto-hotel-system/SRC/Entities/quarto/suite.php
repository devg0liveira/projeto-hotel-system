<?php
namespace Entities\Quarto;

class Suite extends Quarto
{
    public function getDescricao()
    {
        return "Quarto Suíte - Numero: {$this->numero}, Preço: {$this->preco}";
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