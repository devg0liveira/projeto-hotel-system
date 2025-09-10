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
    <?php
    if ($_POST) {
        $nome = htmlspecialchars($_POST['nome']);
        $email = htmlspecialchars($_POST['email']);
        $tipo_pessoa = $_POST['tipo_pessoa'];
        $tipo_quarto = $_POST['tipo_quarto'];
        
        $precos_quarto = [
            'simples' => 150.0,
            'luxo' => 250.0,
            'suite' => 400.0
        ];
        $nomes_quartos =[
            'simples' => 'Quarto Simples',
            'suite' => 'Suíte',
            'luxo' => 'Quarto Luxo'
        ];
        $preco_base = $precos_quarto[$tipo_quarto];
        $preco_final = ($tipo_pessoa == 'pj') ? $preco_base * 1.2 : $preco_base;
    }


    ?>
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