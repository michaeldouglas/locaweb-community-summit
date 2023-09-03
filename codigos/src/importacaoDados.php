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

// Iniciar a tabela HTML com borda, estilo de espaçamento e bordas nas colunas e linhas
$html_table = '<table style="border-collapse: collapse; border-spacing: 0; border: 1px solid black; width: 100%;">';
$html_table .= '<tr style="border: 1px solid black; background-color: #f2f2f2; color: #000;"><th style="border: 1px solid black; padding: 8px;">NOME</th><th style="border: 1px solid black; padding: 8px;">IDADE</th><th style="border: 1px solid black; padding: 8px;">ESTADO</th><th style="border: 1px solid black; padding: 8px;">CIDADE</th><th style="border: 1px solid black; padding: 8px;">VOLTARIA_NO_EVENTO</th></tr>';

foreach ($head as $row) {
    $merged_row = [];
    foreach ($row as $value) {
        $splited_values = explode(",", $value);
        $merged_row = array_merge($merged_row, $splited_values);
    }
    $html_table .= '<tr style="border: 1px solid black;"><td style="border: 1px solid black; padding: 8px;">' . implode('</td><td style="border: 1px solid black; padding: 8px;">', $merged_row) . '</td></tr>';
}

// Fechar a tabela HTML
$html_table .= '</table>';

// Exibir a tabela HTML
echo $html_table;
?>
