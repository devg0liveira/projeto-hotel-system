<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Serviços Adicionais - Hotel System</title>
    <style>
        body {
            text-align: center;
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
            width: 70%;
            max-width: 700px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.3);
        }
        .resumo {
            background: #e8f4fd;
            border: 2px solid #007bff;
            border-radius: 10px;
            padding: 15px;
            margin-bottom: 30px;
        }
        .servico-box {
            border: 2px solid #ddd;
            border-radius: 10px;
            padding: 20px;
            margin: 15px 0;
            background: #f8f9fa;
            transition: all 0.3s ease;
        }
        .servico-box:hover {
            border-color: #28a745;
            box-shadow: 0 5px 15px rgba(40, 167, 69, 0.3);
        }
        .servico-box.selected {
            border-color: #28a745;
            background: #e8f8ec;
        }
        .preco-servico {
            font-weight: bold;
            color: #28a745;
            font-size: 1.1em;
        }
        .preco-pj {
            color: #6c757d;
            font-size: 0.9em;
        }
        .opcoes-restaurante {
            margin-left: 20px;
            display: none;
            background: #fff3cd;
            border: 1px solid #ffeaa7;
            border-radius: 8px;
            padding: 15px;
            margin-top: 10px;
        }
        input[type="checkbox"] {
            margin-right: 10px;
            transform: scale(1.3);
        }
        input[type="submit"] {
            padding: 15px 30px;
            background: linear-gradient(45deg, #28a745, #20c997);
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 1.1em;
            font-weight: bold;
            transition: all 0.3s ease;
            margin-top: 20px;
        }
        input[type="submit"]:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.3);
        }
        .voltar {
            background: #6c757d;
            text-decoration: none;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            display: inline-block;
            margin-right: 15px;
        }
    </style>
</head>
<body>
    <h1>🛎️ Serviços Adicionais</h1>
    
    <div class="container">
        <?php
        // Receber dados do formulário anterior
        if ($_POST) {
            $nome = htmlspecialchars($_POST['nome']);
            $email = htmlspecialchars($_POST['email']);
            $tipo_pessoa = $_POST['tipo_pessoa'];
            $tipo_quarto = $_POST['tipo_quarto'];
            
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
        ?>
        
        <div class="resumo">
            <h4>📋 Resumo da Reserva</h4>
            <p><strong>Cliente:</strong> <?= $nome ?> (<?= $email ?>)</p>
            <p><strong>Tipo:</strong> <?= ($tipo_pessoa == 'pj') ? 'Pessoa Jurídica' : 'Pessoa Física' ?></p>
            <p><strong>Quarto:</strong> <?= $nomes_quartos[$tipo_quarto] ?> - R$ <?= number_format($preco_final, 2, ',', '.') ?>/noite</p>
        </div>

        <form action="confirmacao.php" method="post">
            <!-- Campos ocultos para passar dados adiante -->
            <input type="hidden" name="nome" value="<?= $nome ?>">
            <input type="hidden" name="email" value="<?= $email ?>">
            <input type="hidden" name="tipo_pessoa" value="<?= $tipo_pessoa ?>">
            <input type="hidden" name="tipo_quarto" value="<?= $tipo_quarto ?>">
            
            <h4>✨ Escolha os Serviços Adicionais</h4>
            <p style="color: #666;">Selecione os serviços que deseja contratar:</p>
            
            <!-- SPA -->
            <div class="servico-box">
                <label>
                    <input type="checkbox" name="servicos[]" value="spa" onchange="toggleBox(this)">
                    <strong>🧘 SPA Relaxante</strong><br>
                    <span class="preco-servico">R$ <?= ($tipo_pessoa == 'pj') ? '120,00' : '100,00' ?></span>
                    <?php if($tipo_pessoa == 'pj'): ?>
                        <span class="preco-pj">(PF: R$ 100,00)</span>
                    <?php endif; ?>
                    <br><small>Massagem relaxante, sauna e hidromassagem</small>
                </label>
            </div>
            
            <!-- Estacionamento -->
            <div class="servico-box">
                <label>
                    <input type="checkbox" name="servicos[]" value="estacionamento" onchange="toggleBox(this)">
                    <strong>🚗 Estacionamento VIP</strong><br>
                    <span class="preco-servico">R$ <?= ($tipo_pessoa == 'pj') ? '36,00' : '30,00' ?></span>
                    <?php if($tipo_pessoa == 'pj'): ?>
                        <span class="preco-pj">(PF: R$ 30,00)</span>
                    <?php endif; ?>
                    <br><small>Vaga coberta e segura</small>
                </label>
            </div>

            <!-- Restaurante -->
            <div class="servico-box">
                <label>
                    <input type="checkbox" id="restaurante" onchange="toggleRestaurante(); toggleBox(this)">
                    <strong>🍽️ Restaurante</strong><br>
                    <small>Selecione as refeições desejadas</small>
                </label>

                <div class="opcoes-restaurante" id="opcoesRestaurante">
                    <label>
                        <input type="checkbox" name="servicos[]" value="cafe">
                        Café da manhã - <strong>R$ 20,00</strong>
                    </label><br>
                    <label>
                        <input type="checkbox" name="servicos[]" value="almoco">
                        Almoço - <strong>R$ 30,00</strong>
                    </label><br>
                    <label>
                        <input type="checkbox" name="servicos[]" value="jantar">
                        Jantar - <strong>R$ 30,00</strong>
                    </label>
                    <?php if($tipo_pessoa == 'pj'): ?>
                        <br><small class="preco-pj">* Pessoa Jurídica: +20% em todas as refeições</small>
                    <?php endif; ?>
                </div>
            </div>
            
            <div style="margin-top: 30px;">
                <a href="index.php" class="voltar">⬅️ Voltar</a>
                <input type="submit" value="Finalizar Reserva ✅">
            </div>
        </form>
        
        <?php } else { ?>
            <p style="color: red;">❌ Dados não recebidos. <a href="index.php">Voltar ao início</a></p>
        <?php } ?>
    </div>

    <script>
        function toggleRestaurante() {
            const chkRestaurante = document.getElementById("restaurante");
            const opcoesRestaurante = document.getElementById("opcoesRestaurante");

            if (chkRestaurante.checked) {
                opcoesRestaurante.style.display = "block";
            } else {
                opcoesRestaurante.style.display = "none";
                // Desmarcar todas as opções do restaurante
                opcoesRestaurante.querySelectorAll("input[type=checkbox]").forEach(chk => {
                    chk.checked = false;
                });
            }
        }

        function toggleBox(checkbox) {
            const box = checkbox.closest('.servico-box');
            if (checkbox.checked) {
                box.classList.add('selected');
            } else {
                box.classList.remove('selected');
            }
        }
    </script>
</body>
</html>