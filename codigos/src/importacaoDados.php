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

// Pega 5 no total
$head = array_slice($data, 0, 5);

// Iniciar a tabela HTML com estilo de espaçamento
$html_table = '<table style="border-collapse: separate; border-spacing: 10px;">';
$html_table .= '<tr><th>NOME</th><th>IDADE</th><th>ESTADO</th><th>CIDADE</th><th>VOLTARIA_NO_EVENTO</th></tr>';

foreach ($head as $row) {
    $merged_row = [];
    foreach ($row as $value) {
        $splited_values = explode(",", $value);
        $merged_row = array_merge($merged_row, $splited_values);
    }
    $html_table .= '<tr><td>' . implode('</td><td>', $merged_row) . '</td></tr>';
}

// Fechar a tabela HTML
$html_table .= '</table>';

// Exibir a tabela HTML
echo $html_table;
?>
