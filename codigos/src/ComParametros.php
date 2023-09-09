<?php
require_once 'vendor/autoload.php';

use Phpml\ModelManager;

// Abre a entrada padrão em modo leitura
$stdin = fopen('php://stdin', 'r');

// Lê os dados da entrada padrão (stdin)
$dados_de_entrada = stream_get_contents($stdin);

// Fecha a entrada padrão
fclose($stdin);

// Caminho para o arquivo PKL gerado
$modelPath = __DIR__ . '/modelos/modelo_regressao_logistica.pkl';

// Carregue o modelo a partir do arquivo PKL
$modelManager = new ModelManager();
$classifier = $modelManager->restoreFromFile($modelPath);

// Dados de teste para fazer previsões
$separador = explode(",", $dados_de_entrada);
$testData = [$separador];

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
