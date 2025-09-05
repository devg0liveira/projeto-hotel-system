<?php
namespace Entities;

use Entities\Quarto\Quarto;
use Entities\Pessoa\Pessoa;
use Entities\Servico\ServicoInterface;
use Exception;

class Reserva {
    private $quarto;
    private $hospedes = [];
    private $servicos = [];

    public function __construct(Quarto $quarto) {
        if (!$quarto->estaDisponivel()) {
            throw new Exception("Quarto indisponível");
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

        // se houver PJ, aplicar 20% de acréscimo
        foreach ($this->hospedes as $h) {
            if ($h->getTipo() === "Juridica") {
                $total *= 1.2;
            }
        }

        // calcular serviços
        foreach ($this->servicos as $s) {
            foreach ($this->hospedes as $h) {
                $total += $s->calcularPreco($h);
            }
        }

        return $total;
    }

    public function confirmar() {
        $this->quarto->reservar();
    }
}
