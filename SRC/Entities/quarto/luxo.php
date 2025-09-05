<?php
namespace Entities\Quarto;
class Luxo extends Quarto
{
    public function getDescricao()
    {
        return "Quarto Luxo - Numero: {$this->numero}, Preço: {$this->preco}";
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