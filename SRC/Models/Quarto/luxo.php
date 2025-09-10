<?php
// ========== SRC/Models/Quarto/luxo.php ==========
namespace Hotel\Models\Quartos;

use Hotel\Models\Abstract\Quarto;

class Luxo extends Quarto
{
    public function __construct()
    {
        parent::__construct('Luxo', 150.00);
    }

    public function getTipoNome(): string
    {
        return 'Quarto Luxo';
    }

    public function getDescricao(): string
    {
        $numero = $this->numero ? "#{$this->numero}" : "(número será atribuído)";
        return "Quarto Luxo {$numero} - R$ " . number_format($this->preco, 2, ',', '.') . "/noite";
    }
}