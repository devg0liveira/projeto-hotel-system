<?php

namespace Hotel\Models;

use Hotel\Models\Abstract\{Quarto, Pessoa};
use Hotel\Services\ServicoInterface;
use Exception;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        body {
            text-align: center;
        }
    </style>
</head>

<body>
    <h4>serviços adicionais</h4>
    <label>
        <input type="checkbox" name="servicos[]" value="spa">
        SPA Relaxante - R$100,00
    </label>
    <br>
    <label>
        <input type="checkbox" name="servicos[]" value="estacionamento">
        Estacionamento - R$30,00
    </label>
    <br>
   <label>
    <input type="checkbox" id="restaurante">
    Restaurante
</label>

<div style="margin-left:20px; display:none;" id="opcoesRestaurante">
    <label>
        <input type="checkbox" name="servicos[]" value="cafe">
        Café da manhã - R$20,00
    </label><br>
    <label>
        <input type="checkbox" name="servicos[]" value="almoco">
        Almoço - R$30,00
    </label><br>
    <label>
        <input type="checkbox" name="servicos[]" value="jantar">
        Jantar - R$30,00
    </label>
</div>

<script>
    const chkRestaurante = document.getElementById("restaurante");
    const opcoesRestaurante = document.getElementById("opcoesRestaurante");

    chkRestaurante.addEventListener("change", function() {
        opcoesRestaurante.style.display = this.checked ? "block" : "none";

        if (!this.checked) {
            opcoesRestaurante.querySelectorAll("input[type=checkbox]").forEach(chk => chk.checked = false);
        }
    });
</script>
<br><br>
<form action="/src/Confirmar/Confirmacao.php" method="post">
    <!-- seus checkboxes aqui -->

    <br><br>
    <input type="submit" value="Próximo">
</form>


</body>

</html>

<?php
class Reserva
{
    private $quarto;
    private $hospedes = [];
    private $servicos = [];
    private $confirmada = false;

    public function __construct(Quarto $quarto)
    {
        if (!$quarto->estaDisponivel()) {
            throw new Exception("Quarto indisponível para reserva");
        }
        $this->quarto = $quarto;
    }

    public function adicionarHospede(Pessoa $hospede)
    {
        $this->hospedes[] = $hospede;
    }

    public function adicionarServico(ServicoInterface $servico)
    {
        $this->servicos[] = $servico;
    }

    public function calcularTotal(): float
    {
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

    public function confirmar()
    {
        $this->quarto->reservar();
        $this->confirmada = true;
    }

    // Getters
    public function getQuarto()
    {
        return $this->quarto;
    }
    public function getHospedes()
    {
        return $this->hospedes;
    }
    public function getServicos()
    {
        return $this->servicos;
    }
    public function isConfirmada()
    {
        return $this->confirmada;
    }
}
