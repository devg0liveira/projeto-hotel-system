<?php
namespace HotelSystem\Entities\Pessoa;
class PessoaJuridica extends Pessoa {
    
    public function getTipo() {
        return "Juridica";
    }
    
    public function getTaxaAdicional() {
        return 0.2; // 20% de taxa adicional para pessoas jurídicas
    }
    
}