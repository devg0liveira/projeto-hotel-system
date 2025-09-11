<?php
        // Receber dados do formulário anterior
        if ($_POST) {
            $nome = htmlspecialchars($_POST['nome']);
            $email = htmlspecialchars($_POST['email']);
            $tipo_pessoa = $_POST['tipo_pessoa'];
            $tipo_quarto = $_POST['tipo_quarto'];
            $restaurante = isset($_POST['restaurante']) ? true : false;
            $spa = isset($_POST['spa']) ? true : false;
            $estacionamento = isset($_POST['estacionamento']) ? true : false;
         
            
            // Definir preços dos quartos
            $precos_quartos = [
                'simples' => 150,
                'suite' => 250,
                'luxo' => 400
            ];
            
            $nomes_quartos = [
                'simples' => 'Quarto Simples',
                'suite' => 'Suíte',
                'luxo' => 'Suíte Luxo'
            ];
            
            $preco_base = $precos_quartos[$tipo_quarto];
            $preco_final = ($tipo_pessoa == 'pj') ? $preco_base * 1.2 : $preco_base;
        }