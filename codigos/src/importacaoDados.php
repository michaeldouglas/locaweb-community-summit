<?php

// Ler o arquivo CSV

$csvFile = __DIR__ . '/../dataset/Participantes.csv';
$data = [];
if (($handle = fopen($csvFile, "r")) !== false) {
    while (($row = fgetcsv($handle, 1000, ";")) !== false) {
        $data[] = $row;
    }
    fclose($handle);
}

// Calcular o número total de dados
$total = count($data);

// Exibir o número total de dados
echo "Total de participantes: " . $total . "\n\n";

// Exibir as primeiras 5 linhas do DataFrame
echo "Exibe os 5 primeiros participantes: " . "\n\n";
$head = array_slice($data, 0, 5);
foreach ($head as $row) {
    echo implode(", ", $row) . "\n";
}
?>
