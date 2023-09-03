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

// Exibir as primeiras 5 linhas do DataFrame
echo "Exibe os 5 primeiros participantes: " . "\n";
$head = array_slice($data, 0, 5);

// Criar uma tabela em Markdown com colunas separadas
$markdown_table = "| NOME | IDADE | ESTADO | CIDADE | VOLTARIA_NO_EVENTO |\n";
$markdown_table .= "|------|-------|--------|--------|---------------------|\n";

foreach ($head as $row) {
    $merged_row = [];
    foreach ($row as $value) {
        $splited_values = explode(",", $value);
        $merged_row = array_merge($merged_row, $splited_values);
    }
    $markdown_table .= "| " . implode(" | ", $merged_row) . " |\n";
}

// Exibir a tabela em Markdown
echo $markdown_table;
?>
