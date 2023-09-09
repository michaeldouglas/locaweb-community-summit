<?php
// Lê os dados da entrada padrão (stdin)
$dados_do_python = file_get_contents("php://stdin");

// Imprime os dados recebidos
echo "Dados recebidos do Python:\n";
echo $dados_do_python;
?>