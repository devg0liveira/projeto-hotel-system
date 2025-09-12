<?php
require_once '../vendor/autoload.php';

use Hotel\Models\Pessoas\{PessoaFisica, PessoaJuridica};
use Hotel\Models\Quartos\{Simples, Suite, Luxo};
use Hotel\Models\Reserva;
use Hotel\Services\{Spa, Estacionamento, Restaurante};

// === 1. Receber dados via POST ===
$nome = $_POST['nome'] ?? '';
$email = $_POST['email'] ?? '';
$tipoPessoa = $_POST['tipo_pessoa'] ?? 'fisica';
$tipoQuarto = $_POST['quarto'] ?? '';
$servicosSelecionados = $_POST['servicos'] ?? [];

// === 2. Criar Pessoa ===
if ($tipoPessoa === 'juridica') {
    $pessoa = new PessoaJuridica($nome, $email);
} else {
    $pessoa = new PessoaFisica($nome, $email);
}

// === 3. Criar Quarto ===
switch ($tipoQuarto) {
    case 'simples':
        $quarto = new Simples();
        break;
    case 'suite':
        $quarto = new Suite();
        break;
    case 'luxo':
        $quarto = new Luxo();
        break;
    default:
        die("Quarto inválido!");
}

// === 4. Criar Serviços ===
$servicos = [];
foreach ($servicosSelecionados as $s) {
    switch ($s) {
        case 'spa':
            $servicos[] = new Spa();
            break;
        case 'restaurante':
            $servicos[] = new Restaurante();
            break;
        case 'estacionamento':
            $servicos[] = new Estacionamento();
            break;
    }
}

// === 5. Criar Reserva ===
$reserva = new Reserva($pessoa, $quarto, $servicos);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Confirmação de Reserva</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 30px;
            line-height: 1.6;
        }
        h2, h3 {
            color: #333;
        }
        ul {
            list-style-type: square;
        }
        .total {
            font-size: 1.2em;
            font-weight: bold;
            color: darkgreen;
        }
    </style>
</head>
<body>
    <h2>Confirmação da Reserva</h2>

    <!-- Dados da Pessoa -->
    <p><strong>Nome:</strong> <?= htmlspecialchars($pessoa->getNome()) ?></p>
    <p><strong>Email:</strong> <?= htmlspecialchars($pessoa->getEmail()) ?></p>

    <!-- Quarto escolhido -->
    <p><strong>Quarto escolhido:</strong> 
        <?= $quarto->getDescricao() ?> - 
        R$ <?= number_format($quarto->calcularPreco($pessoa), 2, ',', '.') ?>
    </p>

    <!-- Serviços adicionais -->
    <h3>Serviços adicionais:</h3>
    <?php if (!empty($servicos)) : ?>
        <ul>
            <?php foreach ($servicos as $servico) : ?>
                <li>
                    <?= $servico->getDescricao() ?> - 
                    R$ <?= number_format($servico->calcularPreco($pessoa), 2, ',', '.') ?>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else : ?>
        <p>Nenhum serviço adicional selecionado.</p>
    <?php endif; ?>

    <!-- Total da Reserva -->
    <h3>Total da reserva:</h3>
    <p class="total">
        R$ <?= number_format($reserva->calcularTotal(), 2, ',', '.') ?>
    </p>
</body>
</html>
