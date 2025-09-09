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
        }
        .box {
            border: 1px solid #ccc;
            padding: 15px;
            margin: 15px auto;
            width: 60%;
            border-radius: 8px;
            background: #f9f9f9;
        }
        .price {
            font-weight: bold;
            color: green;
        }
        .price-detail {
            font-size: 0.9em;
            color: gray;
        }
        input[type="text"], input[type="email"] {
            width: 80%;
            padding: 8px;
            margin: 8px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        input[type="submit"] {
            padding: 10px 20px;
            background: darkblue;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background: navy;
        }
    </style>
</head>
<body>
    <h2>🏨 Bem-vindo ao Hotel System</h2>
    <p>Preencha seus dados e escolha uma opção de quarto</p>

    <form action="quarto.php" method="post">

        <div class="box">
            <h4>Dados do Cliente</h4>
            <input type="text" name="nome" placeholder="Nome completo" required><br>
            <input type="email" name="email" placeholder="E-mail" required>
        </div>

        <div class="box">
            <h4>Tipo de Cliente</h4>
            <input type="radio" id="pessoa_fisica" name="tipo_pessoa" value="pf" required checked>
            <label for="pessoa_fisica">
                Pessoa Física
                <span class="price-detail">(preços normais)</span>
            </label>
            <br>
            <input type="radio" id="pessoa_juridica" name="tipo_pessoa" value="pj">
            <label for="pessoa_juridica">
                Pessoa Jurídica
                <span class="price-detail">(20% a mais em todos os quartos)</span>
            </label>
        </div>

        <div class="box">
            <h4>Escolha o Quarto</h4>
            <input type="radio" id="quarto_simples" name="tipo_quarto" value="simples" required>
            <label for="quarto_simples">
                Quarto Simples - <span class="price">R$ 150/noite</span>
                <span class="price-detail">PJ: R$ 180/noite</span>
            </label>
            <br>
            <input type="radio" id="suite" name="tipo_quarto" value="suite">
            <label for="suite">
                Suíte - <span class="price">R$ 250/noite</span>
                <span class="price-detail">PJ: R$ 300/noite</span>
            </label>
            <br>
            <input type="radio" id="luxo" name="tipo_quarto" value="luxo">
            <label for="luxo">
                Suíte Luxo - <span class="price">R$ 400/noite</span>
                <span class="price-detail">PJ: R$ 480/noite</span>
            </label>
        </div>

            <a href="reserva.php"><input type="submit" value="Reservar"></a>
    </form>
</body>
</html>
