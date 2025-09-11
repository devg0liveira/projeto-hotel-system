<?php
require_once '../vendor/autoload.php';

use Hotel\Models\Pessoas\{PessoaFisica, PessoaJuridica};
use Hotel\Models\Quartos\{Simples, Suite, Luxo};
use Hotel\Models\Reserva;
use Hotel\Services\{Spa, Estacionamento, Restaurante};

// === 1. Recebe os dados enviados do formulário ===
$nome = $_POST['nome'] ?? '';
$email = $_POST['email'] ?? '';
$tipoPessoa = $_POST['tipo_pessoa'] ?? 'fisica'; // fisica ou juridica
$tipoQuarto = $_POST['quarto'] ?? '';
$servicosSelecionados = $_POST['servicos'] ?? []; // array de checkboxes
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmação da Reserva - Hotel System</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            color: white;
        }
        .container {
            background: rgba(255, 255, 255, 0.95);
            color: #333;
            border-radius: 15px;
            padding: 30px;
            margin: 20px auto;
            max-width: 800px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.3);
        }
        .resumo-box {
            background: #f8f9fa;
            border: 2px solid #28a745;
            border-radius: 10px;
            padding: 20px;
            margin: 20px 0;
        }
        .erro {
            background: #f8d7da;
            border: 2px solid #dc3545;
            color: #721c24;
            padding: 15px;
            border-radius: 8px;
            margin: 20px 0;
        }
        .sucesso {
            background: #d4edda;
            border: 2px solid #28a745;
            color: #155724;
            padding: 15px;
            border-radius: 8px;
            margin: 20px 0;
        }
        .preco-destaque {
            font-weight: bold;
            color: #28a745;
            font-size: 1.2em;
        }
        .taxa-pj {
            color: #dc3545;
            font-size: 0.9em;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 15px 0;
        }
        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background: #e9ecef;
            font-weight: bold;
        }
        .btn {
            padding: 15px 30px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 1.1em;
            font-weight: bold;
            margin: 10px 5px;
            transition: all 0.3s ease;
        }
        .btn-primary {
            background: linear-gradient(45deg, #28a745, #20c997);
            color: white;
        }
        .btn-secondary {
            background: #6c757d;
            color: white;
        }
        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.3);
        }
    </style>