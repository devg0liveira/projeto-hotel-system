<?php
namespace HotelSystem\Entities\Pessoa;

abstract class Pessoa {
    protected $nome;
    protected $email;

    public function __construct($nome, $email) {
        $this->nome = $nome;
        $this->email = $email;
    }

    // Métodos abstratos
    abstract public function getTipo();
    abstract public function getTaxaAdicional();

    // Getters básicos (já implementados na classe pai)
    public function getNome() {
        return $this->nome;
    }

    public function getEmail() {
        return $this->email;
    }
}
?>