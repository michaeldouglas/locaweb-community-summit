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

$html_table = '<table style="border-collapse: collapse; border-spacing: 0; border: 1px solid black; width: 100%;">';
$html_table .= '<tr style="border: 1px solid black; background-color: #f2f2f2; color: #000;"><th style="border: 1px solid black; padding: 8px;">Total de participantes</th></tr>';

$html_table .= '<tr style="border: 1px solid black;">
<td style="border: 1px solid black; padding: 8px;">' . $total . '</td></tr>';

$html_table .= '</table>';

echo $html_table;