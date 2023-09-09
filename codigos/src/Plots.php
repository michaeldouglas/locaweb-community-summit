<?php
$csvFile = __DIR__ . '/../dataset/Participantes.csv';
$data = [];
if (($handle = fopen($csvFile, "r")) !== false) {
    // Pular a primeira linha (cabeçalho)
    fgetcsv($handle, 1000, ";");
    
    while (($row = fgetcsv($handle, 1000, ";")) !== false) {
        $data[] = $row;
    }
    fclose($handle);
}

// Obtem as respostas
$responses = [];
foreach ($data as $row) {
    $split = explode(',', $row[0]);
    $responses[] = $split;
}

// Escolhendo a coluna "VOLTARIA_NO_EVENTO"
$columnIndex = 4;

// Extrair a coluna de dados escolhida
$columnData = array_column($responses, $columnIndex);

// Calcular a média da frequência de "sim" (1), considerando zero se não houver ocorrências de "sim"
$total = count($columnData);
if ($total > 0) {
    //Retornaria
    $sumSim = array_sum(array_map(function ($x) {
        return strtolower($x) === 'sim' ? 1 : 0;
    }, $columnData));

    //Retornaria
    $sumNao = array_sum(array_map(function ($x) {
        return strtolower($x) === 'nao' ? 1 : 0;
    }, $columnData));

    print_r($sumSim);
}

?>


<!DOCTYPE html>
<html>
<head>
    <title>Boxplot da coluna "VOLTARIA_NO_EVENTO"</title>
    <script src="https://cdn.plot.ly/plotly-latest.min.js"></script>
</head>
<body>
    <h1>dsadsadsadsa</h1>
</body>
</html>