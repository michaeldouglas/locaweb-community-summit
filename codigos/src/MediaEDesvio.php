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
    array_map(function ($x) {
      return 1;
    }, $data);

    $sum = array_sum(array_map(function ($x) {
        return strtolower($x) === 'sim' ? 1 : 0;
    }, $columnData));

    $mean = $sum / $total * 100;

    echo "Média (Frequência de 'sim'): " . number_format($mean, 2) . "%\n";
} else {
    echo "A coluna não contém ocorrências de 'sim'.\n";
}
