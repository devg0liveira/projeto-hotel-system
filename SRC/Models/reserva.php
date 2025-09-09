<?php
namespace Hotel\Models;

use Hotel\Models\Abstract\{Quarto, Pessoa};
use Hotel\Services\ServicoInterface;
use Exception;

class Reserva {
    private $quarto;
    private $hospedes = [];
    private $servicos = [];
    private $confirmada = false;
    
    public function __construct(Quarto $quarto) {
        if (!$quarto->estaDisponivel()) {
            throw new Exception("Quarto indisponível para reserva");
        }
        $this->quarto = $quarto;
    }
    
    public function adicionarHospede(Pessoa $hospede) {
        $this->hospedes[] = $hospede;
    }
    
    public function adicionarServico(ServicoInterface $servico) {
        $this->servicos[] = $servico;
    }
    
    public function calcularTotal(): float {
        $total = $this->quarto->getPreco();
        
        // Adicional para Pessoa Jurídica no quarto
        foreach ($this->hospedes as $hospede) {
            if ($hospede->getTipo() === "Juridica") {
                $total *= 1.2; // 20% adicional
                break; // Aplica apenas uma vez por reserva
            }
        }
        
        // Calcular serviços
        foreach ($this->servicos as $servico) {
            foreach ($this->hospedes as $hospede) {
                $total += $servico->calcularPreco($hospede);
            }
        }
        
        return $total;
    }
    
    public function confirmar() {
        $this->quarto->reservar();
        $this->confirmada = true;
    }
    
    // Getters
    public function getQuarto() { return $this->quarto; }
    public function getHospedes() { return $this->hospedes; }
    public function getServicos() { return $this->servicos; }
    public function isConfirmada() { return $this->confirmada; }
}