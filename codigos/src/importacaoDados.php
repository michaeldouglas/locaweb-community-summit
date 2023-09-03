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
echo "Exibe os 5 primeiros participantes: " . "\n";
$head = array_slice($data, 0, 5);

// Criar uma tabela HTML
$html_table = '<table>';
$html_table .= '<tr><th>NOME</th><th>IDADE</th><th>ESTADO</th><th>CIDADE</th><th>VOLTARIA_NO_EVENTO</th></tr>';

foreach ($head as $row) {
    $html_table .= '<tr>';
    foreach ($row as $value) {
        $html_table .= '<td>' . htmlspecialchars($value) . '</td>';
    }
    $html_table .= '</tr>';
}

$html_table .= '</table>';

// Exibir a tabela HTML
echo $html_table;
?>
