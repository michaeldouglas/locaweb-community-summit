<?php
// Ler o arquivo CSV
$csvFile = __DIR__ . '/../dataset/Participantes.csv';
$data = [];
if (($handle = fopen($csvFile, "r")) !== false) {
    // Remover a primeira linha (cabeçalho)
    fgetcsv($handle, 1000, ";");
    
    while (($row = fgetcsv($handle, 1000, ";")) !== false) {
        $data[] = $row;
    }
    fclose($handle);
}

// Calcular o número total de dados
$total = count($data);

// Exibir o número total de dados
echo "Total de participantes: " . $total . "\n\n";