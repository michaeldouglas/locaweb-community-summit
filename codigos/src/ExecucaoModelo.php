<?php
require_once 'vendor/autoload.php';

use Phpml\ModelManager;

// Caminho para o arquivo PKL gerado
$modelPath = __DIR__ . '/modelos/modelo_regressao_logistica.pkl';

// Carregue o modelo a partir do arquivo PKL
$modelManager = new ModelManager();
$classifier = $modelManager->restoreFromFile($modelPath);

// Dados de teste para fazer previsões
$testData = [
  [30, 1, 1],
  [25, 1, 1],
  [50, 1, 1],
  [40, 1, 1],
  [30, 1, 1],
  [20, 1, 1],
  [30, 1, 4],
];


// Faça previsões com o modelo carregado
$predictions = $classifier->predict($testData);

// Converta os resultados de volta para 'SIM' ou 'NAO'
$predictions = array_map(function ($prediction) {
    return ($prediction === 'SIM') ? 'SIM' : 'NAO';
}, $predictions);

// Mapeie características categóricas para valores numéricos
$stateMapping = [
  'SAO_PAULO' => 1,
  'MINAS_GERAIS' => 2,
  'RIO_JANEIRO' => 3,
];

$cityMapping = [
  'SAO_PAULO' => 1,
  'BELO_HORIZONTE' => 2,
  'RIO_JANEIRO' => 3,
  'JUNDIAI' => 4
];

?>

<!DOCTYPE html>
<html>
<head>
    <title>Resultados</title>
    <style>
        /* Estilo para tornar a tabela responsiva */
        table {
            width: 100%;
            border-collapse: collapse;
            border: 1px solid #000; /* Adicionar borda à tabela */
        }

        /* Estilo para alternar cores das linhas */
        tr:nth-child(even) {
            background-color: #f2f2f2;
            color: black;
        }

        /* Estilo para os cabeçalhos com cores diferentes */
        th {
            background-color: #f2f2f2;
            color: black;
        }

        /* Estilo para as células da tabela */
        td, th {
            padding: 8px;
            border: 1px solid #000;
            text-align: left;
        }
        .green {
            color: green;
            font-weight: bold;
        }
        .red {
            color: red;
            font-weight: bold;
        }
        .justify {
            align-items: center;
            display: flex;
        }
        .justify i {
            margin-left: 0.3rem;
        }
    </style>
    <link
            rel="stylesheet"
            href="https://fonts.googleapis.com/icon?family=Material+Icons"
    />
</head>
<body>
<div style="text-align: center;"><img src='https://php.locaweb.com.br/wp-content/themes/locaweb-php-community-2023/svg/logo.svg' alt='php-community-2023' /><div><br />
    <table border="1">
        <tr>
            <th>Idade</th>
            <th>Estado</th>
            <th>Cidade</th>
            <th>Resultado</th>
        </tr>

        <!-- Exiba as previsões em uma tabela HTML -->
        <?php foreach ($predictions as $index => $prediction) : ?>
            <?php
            $testSample = $testData[$index];
            $idade = $testSample[0];
            $estado = array_search($testSample[1], $stateMapping); // Converter de volta para o nome do estado
            $cidade = array_search($testSample[2], $cityMapping); // Converter de volta para o nome da cidade
            $result = $prediction === 'SIM' ? 'Retornaria ao evento' : 'Não retornaria ao evento';
            $class = $prediction === 'SIM' ? 'green' : 'red';
            $icon = $prediction === 'SIM' ? 'check' : 'block';
            ?>
            <tr>
                <td class="<?php echo $class; ?>"><?php echo $idade; ?></td>
                <td class="<?php echo $class; ?>"><?php echo $estado; ?></td>
                <td class="<?php echo $class; ?>"><?php echo $cidade; ?></td>
                <td class="<?php echo $class; ?>">
                    <div class="justify">
                        <?php echo $result; ?> <i class="material-icons"><?php echo $icon; ?></i>
                    </div>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
    <!-- Resto do seu código HTML -->
</body>
</html>
