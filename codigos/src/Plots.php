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

$columnDataEstado = array_column($responses, 2);

// Calcular a média da frequência de "sim" (1), considerando zero se não houver ocorrências de "sim"
$total = count($columnData);
if ($total > 0) {
    //Retornaria
    $sumSim = array_sum(array_map(function ($x) {
        return strtolower($x) === 'sim' ? 1 : 0;
    }, $columnData));

    //Retornaria
    $sumNao = array_sum(array_map(function ($x) {
        return strtolower($x) === 'nao' ? 1 : 0;
    }, $columnData));

    // Contagem estados
    $contagem = array_count_values($columnDataEstado);

    $codigosEstado = [
        "SAO_PAULO" => "SP",
        "MINAS_GERAIS" => "MG",
        "RIO_JANEIRO" => "RJ",
    ];

    $contagemFormatada = [];

    foreach ($contagem as $estado => $quantidade) {
        if (isset($codigosEstado[$estado])) {
            $contagemFormatada[$codigosEstado[$estado]] = $quantidade;
        }
    }

    // Dados para os gráficos de boxplot
    $boxplotDataEstado = [
        "SP" => array_filter($columnDataEstado, function ($estado) use ($codigosEstado) {
            return $codigosEstado[$estado] === "SP";
        }),
        "MG" => array_filter($columnDataEstado, function ($estado) use ($codigosEstado) {
            return $codigosEstado[$estado] === "MG";
        }),
        "RJ" => array_filter($columnDataEstado, function ($estado) use ($codigosEstado) {
            return $codigosEstado[$estado] === "RJ";
        }),
    ];
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Gráfico de Contagem e Boxplots</title>
    <script src='https://cdn.plot.ly/plotly-2.25.2.min.js'></script>
    <style>
        .graph-container {
            display: flex;
            flex-wrap: wrap; /* Permite que os gráficos sejam distribuídos em várias linhas */
        }

        .graph {
            flex: 1;
            margin: 10px; /* Espaçamento entre os gráficos */
            box-sizing: border-box; /* Considera a margem no tamanho total */
        }

        .graph-full {
            flex: 2; /* Ocupa duas vezes o espaço horizontal */
        }
    </style>
</head>
<body>
    <div class='graph-container'>
        <div class='graph' id='myDiv'></div>
        <div class='graph' id='totalDiv'></div>
    </div>
    <div class='graph-container'>

        <div class='graph graph-full' id='pie1'></div>
        <div class='graph graph-full' id='pie2'></div>
    </div>

    <script>

        // Código JavaScript para criar os gráficos de barras (já existentes)
        var x = ["Voltaria", "Não Voltaria"];
        var y = [<?php echo $sumSim; ?>, <?php echo $sumNao; ?>];

        var data = [
          {
            x: x,
            y: y,
            type: "bar",
            text: y.map(String),
            textposition: 'auto',
            hoverinfo: 'y+text',
            marker: {
                color: ['green', 'red']
            }
          }
        ];

        var layout = {
            title: 'Contagem de Participantes',
            xaxis: {
                title: 'Resposta',
            },
            yaxis: {
                title: 'Contagem',
            },
            font: {
                size: 16 // Tamanho da fonte dos rótulos das barras
            }
        };

        Plotly.newPlot('myDiv', data, layout);

        // Totais de SP, MG e RJ (substitua com os valores reais)
        var totalSP = <?php echo $contagemFormatada['SP'] ?>;
        var totalMG = <?php echo $contagemFormatada['MG'] ?>;
        var totalRJ = <?php echo $contagemFormatada['RJ'] ?>;

        var dataTotal = [
          {
            x: ["SP", "MG", "RJ"],
            y: [totalSP, totalMG, totalRJ],
            type: "bar",
            text: [totalSP, totalMG, totalRJ],
            textposition: 'inside',
            hoverinfo: 'none',
            marker: {
                color: ['blue', 'orange', 'purple']
            }
          }
        ];

        var layoutTotal = {
            title: 'Total de participantes por Estado',
            xaxis: {
                title: 'Estado',
                tickvals: [0, 1, 2],
                ticktext: ["SP", "MG", "RJ"],
            },
            yaxis: {
                title: 'Total',
            },
            font: {
                size: 16
            }
        };

        Plotly.newPlot('totalDiv', dataTotal, layoutTotal);

        // Pies
        var data = [{
          values: [<?php echo $sumSim; ?>, <?php echo $sumNao; ?>],
          labels: ["Voltaria", "Não Voltaria"],
          type: 'pie'
        }];

        Plotly.newPlot('pie1', data);

        var data = [{
          values: [totalSP, totalMG, totalRJ],
          labels: ["SP", "MG", "RJ"],
          type: 'pie'
        }];

        
        Plotly.newPlot('pie2', data);
    </script>
</body>
</html>
