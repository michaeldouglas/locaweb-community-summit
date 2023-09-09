<?php

require_once 'vendor/autoload.php';

use Phpml\Dataset\CsvDataset;

// Carregue o conjunto de dados CSV
$dataset = new CsvDataset(__DIR__ . '/../dataset/Participantes.csv', 4, true);

// Obtendo nossas amostras (features)
$samples = $dataset->getSamples();

// Obtendo nossa (target)
$targets = $dataset->getTargets();

?>


<!DOCTYPE html>
<html>
<head>
    <title>Dataset</title>
    <style>
        /* Estilo para tornar a tabela responsiva */
        table {
            width: 100%;
            border-collapse: collapse;
            border: 1px solid #000; /* Adicionar borda à tabela */
        }

        /* Estilo para alternar cores das linhas */
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        /* Estilo para os cabeçalhos com cores diferentes */
        th {
            background-color: #f2f2f2;
            color: black;
        }

        /* Estilo para as células da tabela */
        td, th {
            padding: 8px;
            border: 1px solid #000;
            text-align: left;
        }
    </style>
</head>
<body>

<table>
    <tr>
        <th>Amostra</th>
        <th>Variavel target</th>
    </tr>
    <?php foreach ($samples as $index => $sample): ?>
    <tr>
        <td><?php echo implode(', ', $sample); ?></td>
        <td><?php echo $targets[$index]; ?></td>
    </tr>
    <?php endforeach; ?>
</table>

</body>
</html>