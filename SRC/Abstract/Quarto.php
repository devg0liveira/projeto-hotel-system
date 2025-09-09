<?php
namespace Hotel\Models\Abstract;

abstract class Quarto
{
    protected $numero;
    protected $disponivel;
    protected $preco;

    public function __construct($numero, $preco)
    {
        $this->numero = $numero;
        $this->preco = $preco;
        $this->disponivel = true;
    }

    abstract public function getDescricao();

    public function estaDisponivel()
    {
        return $this->disponivel;
    }

    public function reservar()
    {
        $this->disponivel = false;
    }

    public function liberar()
    {
        $this->disponivel = true;
    }

    public function getPreco()
    {
        return $this->preco;
    }

    public function getNumero()
    {
        return $this->numero;
    }
}
