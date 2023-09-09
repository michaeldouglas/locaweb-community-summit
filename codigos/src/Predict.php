<?php

require_once 'vendor/autoload.php';

use Phpml\Classification\Linear\LogisticRegression;
use Phpml\Dataset\CsvDataset;
use Phpml\FeatureExtraction\TfIdfTransformer;
use Phpml\Metric\Accuracy;
use Phpml\ModelManager;


// Carregue o conjunto de dados CSV
$dataset = new CsvDataset(__DIR__ . '/../dataset/Participantes.csv', 4, true);

// Obtendo nossas amostras (features)
$samples = $dataset->getSamples();

// Obtendo nossa (target)
$targets = $dataset->getTargets();

// Mapeie características categóricas para valores numéricos
$stateMapping = [
  'SAO_PAULO' => 1,
  'MINAS_GERAIS' => 2,
  'RIO_JANEIRO' => 3,
  // Adicione outros estados aqui
];

$cityMapping = [
  'SAO_PAULO' => 1,
  'BELO_HORIZONTE' => 2,
  'RIO_JANEIRO' => 3,
  'JUNDIAI' => 4
];

$samplesEncoded = [];

foreach ($samples as $sample) {
  $age = (int) $sample[1];
  $state = $stateMapping[$sample[2]];
  $city = $cityMapping[$sample[3]];

  $combinedFeature = [$age, $state, $city];
  
  $samplesEncoded[] = $combinedFeature;
}

// Crie um classificador de regressão logística
$classifier = new LogisticRegression();
$classifier->train($samplesEncoded, $targets);

// Dados de teste
$testData = [
  [20, 'SAO_PAULO', 'SAO_PAULO'],
  [20, 'SAO_PAULO', 'SAO_PAULO'],
  [18, 'SAO_PAULO', 'JUNDIAI'],
  [22, 'MINAS_GERAIS', 'BELO_HORIZONTE'],
  [50, 'SAO_PAULO', 'SAO_PAULO'],
  [51, 'SAO_PAULO', 'SAO_PAULO'],
  [25, 'RIO_JANEIRO', 'RIO_JANEIRO'],
  [16, 'RIO_JANEIRO', 'RIO_JANEIRO'],
  [20, 'RIO_JANEIRO', 'RIO_JANEIRO'],
  [18, 'RIO_JANEIRO', 'RIO_JANEIRO'],
  [39, 'MINAS_GERAIS', 'BELO_HORIZONTE'],
  [33, 'MINAS_GERAIS', 'BELO_HORIZONTE'],
  [35, 'MINAS_GERAIS', 'BELO_HORIZONTE'],
];

// Mapeie os dados de teste para valores numéricos da mesma forma
$testDataEncoded = [];

foreach ($testData as $testSample) {
  $age = (int)$testSample[0];
  $state = $stateMapping[$testSample[1]];
  $city = $cityMapping[$testSample[2]];

  $combinedFeature = [$age, $state, $city];

  $testDataEncoded[] = $combinedFeature;
}

// Preveja se as pessoas retornariam ao evento
$predictions = $classifier->predict($testDataEncoded);

// Converte 'SIM' para 1 e 'NAO' para 0 nos arrays $predictions e $targets
$predictions = array_map(function($prediction) {
  return ($prediction === 'SIM') ? 1 : 0;
}, $predictions);

$targets = array_map(function($target) {
  return ($target === 'SIM') ? 1 : 0;
}, $targets);

// Avalie a precisão do modelo
$accuracy = Accuracy::score($predictions, $targets);
$precisionPercent = round($accuracy * 100, 2);

// Salve o modelo treinado para uso futuro (opcional)
$modelManager = new ModelManager();
$modelManager->saveToFile($classifier, __DIR__ . '/modelos/modelo_regressao_logistica.pkl');

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
            $sample = $samples[$index];
            $idade = $sample[1];
            $estado = $sample[2];
            $cidade = $sample[3];
            $result = $prediction === 1 ? 'Retornaria ao evento' : 'Não retornaria ao evento';
            $class = $prediction === 1 ? 'green' : 'red';
            $icon = $prediction === 1 ? 'check' : 'block';
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
    <h2>Resultado final</h2>
    <table border="1">
      <tr>
        <th>Precisão do modelo</th>
        <th>Modelo gerado com sucesso</th>
      </tr>
      <tr>
        <td><?php echo $precisionPercent;?>%</td>
        <td><a target="_blank" href="/<?php echo '/content/locaweb-community-summit/codigos/src/modelos/modelo_regressao_logistica.pkl'; ?>">Baixar o modelo</a></td>
      </tr>
    </table>

    <!-- Resto do seu código HTML -->
</body>
</html>