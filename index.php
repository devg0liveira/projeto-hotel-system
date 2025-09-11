<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hotel System</title>
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
            max-width: 600px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.3);
        }
        .box {
            border: 2px solid #ddd;
            padding: 20px;
            margin: 20px 0;
            border-radius: 10px;
            background: #f8f9fa;
            transition: all 0.3s ease;
        }
        .box:hover {
            border-color: #667eea;
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.3);
        }
        .price {
            font-weight: bold;
            color: #28a745;
            font-size: 1.1em;
        }
        .price-detail {
            font-size: 0.9em;
            color: #666;
        }
        .availability {
            font-size: 0.8em;
            color: #007bff;
            font-weight: bold;
        }
        .unavailable {
            color: #dc3545;
        }
        input[type="text"], input[type="email"] {
            width: 80%;
            padding: 12px;
            margin: 8px 0;
            border: 2px solid #ddd;
            border-radius: 8px;
            font-size: 1em;
        }
        input[type="text"]:focus, input[type="email"]:focus {
            border-color: #667eea;
            outline: none;
            box-shadow: 0 0 5px rgba(102, 126, 234, 0.3);
        }
        input[type="submit"] {
            padding: 15px 30px;
            background: linear-gradient(45deg, #667eea, #764ba2);
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 1.1em;
            font-weight: bold;
            transition: all 0.3s ease;
        }
        input[type="submit"]:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.3);
        }
        input[type="radio"] {
            margin-right: 10px;
            transform: scale(1.2);
        }
        .hotel-title {
            color: white;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.5);
            margin-bottom: 30px;
        }
    </style>
</head>
<body>
    <h1 class="hotel-title">🏨 Bem-vindo ao Hotel System</h1>
    <p style="color: white; font-size: 1.1em;">Preencha seus dados e escolha uma opção de quarto</p>

    <div class="container">
        <form action="servicos.php" method="post">
            <div class="box">
                <h4>📝 Dados do Cliente</h4>
                <input type="text" name="nome" placeholder="Nome completo" required><br>
                <input type="email" name="email" placeholder="E-mail" required>
            </div>

            <div class="box">
                <h4>👤 Tipo de Cliente</h4>
                <input type="radio" id="pessoa_fisica" name="tipo_pessoa" value="pf" required checked>
                <label for="pessoa_fisica">
                    Pessoa Física
                    <span class="price-detail">(preços normais)</span>
                </label>
                <br><br>
                <input type="radio" id="pessoa_juridica" name="tipo_pessoa" value="pj">
                <label for="pessoa_juridica">
                    Pessoa Jurídica
                    <span class="price-detail">(20% adicional nos quartos)</span>
                </label>
            </div>

            <div class="box">
                <h4>🛏️ Escolha o Quarto</h4>
                
                <input type="radio" id="quarto_simples" name="tipo_quarto" value="simples" required>
                <label for="quarto_simples">
                    Quarto Simples - <span class="price">R$ 150/noite</span><br>
                    <span class="price-detail">PJ: R$ 180/noite</span><br>
                    <span class="availability">📊 20 quartos disponíveis (101-120)</span>
                </label>
                <br><br>
                
                <input type="radio" id="suite" name="tipo_quarto" value="suite">
                <label for="suite">
                    Suíte - <span class="price">R$ 250/noite</span><br>
                    <span class="price-detail">PJ: R$ 300/noite</span><br>
                    <span class="availability">📊 10 suítes disponíveis (201-210)</span>
                </label>
                <br><br>
                
                <input type="radio" id="luxo" name="tipo_quarto" value="luxo">
                <label for="luxo">
                    Suíte Luxo - <span class="price">R$ 400/noite</span><br>
                    <span class="price-detail">PJ: R$ 480/noite</span><br>
                    <span class="availability">📊 5 suítes disponíveis (301-305)</span>
                </label>
            </div>

            <input type="submit" value="Próximo: Escolher Serviços ➡️">
        </form>
    </div>
</body>
</html>