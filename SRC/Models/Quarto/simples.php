<?php
// ========== SRC/Models/Quarto/simples.php ==========
namespace Hotel\Models\Quartos;

use Hotel\Models\Abstract\Quarto;

class Simples extends Quarto
{
    public function __construct()
    {
        parent::__construct('simples', 150.00);
    }

    public function getTipoNome(): string
    {
        return 'Quarto Simples';
    }

    public function getDescricao(): string
    {
        $numero = $this->numero ? "#{$this->numero}" : "(número será atribuído)";
        return "Quarto Simples {$numero} - R$ " . number_format($this->preco, 2, ',', '.') . "/noite";
    }
}