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

// Obtem as respostas
$responses = [];
foreach ($data as $row) {
    $split = explode(',', $row[0]);
    $responses[] = $split;
}
$columnIndex = 4;
$columnData = array_column($responses, $columnIndex);

// Exibir o total
$html_table = '<table style="border-collapse: collapse; border-spacing: 0; border: 1px solid black; width: 100%;">';
$html_table .= '<tr style="border: 1px solid black; background-color: #f2f2f2; color: #000;">
<th style="border: 1px solid black; padding: 8px;">Total de participantes</th>
<th style="border: 1px solid black; padding: 8px;">Total voltaria no evento</th>
</tr>';

$total = count($columnData);
if ($total > 0) {
  $totalVoltaria = array_sum(array_map(function ($x) {
    return strtolower($x) === 'sim' ? 1 : 0;
  }, $columnData));

  $totalNaoVoltaria = array_sum(array_map(function ($x) {
    return strtolower($x) === 'nao' ? 1 : 0;
  }, $columnData));
}

$html_table .= '<tr style="border: 1px solid black;">
  <td style="border: 1px solid black; padding: 8px;">' . $total . '</td>
  <td style="border: 1px solid black; padding: 8px;">' . $totalVoltaria . '</td>
  <td style="border: 1px solid black; padding: 8px;">' . $totalNaoVoltaria . '</td>
</tr>';

$html_table .= '</table>';

echo $html_table;