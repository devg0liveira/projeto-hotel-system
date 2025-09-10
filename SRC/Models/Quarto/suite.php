<?php
// ========== SRC/Models/Quarto/suite.php ==========
namespace Hotel\Models\Quartos;

use Hotel\Models\Abstract\Quarto;

class Suite extends Quarto
{
    public function __construct()
    {
        parent::__construct('Suite', 150.00);
    }

    public function getTipoNome(): string
    {
        return 'Quarto Suite';
    }

    public function getDescricao(): string
    {
        $numero = $this->numero ? "#{$this->numero}" : "(número será atribuído)";
        return "Quarto Suite {$numero} - R$ " . number_format($this->preco, 2, ',', '.') . "/noite";
    }
}