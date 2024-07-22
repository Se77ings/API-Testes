<?php
if (isset($_GET['idSolicitacao'])) {
    $idSolicitacao = $_GET['idSolicitacao'];
    $apiUrl = "http://192.168.0.216:3000/solicitacoes/solicitacao/" . $idSolicitacao;
    // Inicializa o cURL
    $ch = curl_init();

    // Configurações do cURL
    curl_setopt($ch, CURLOPT_URL, $apiUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    // Executa a solicitação e obtém a resposta
    $response = curl_exec($ch);

    // Verifica se ocorreu algum erro na solicitação
    if ($response === false) {
        echo "Erro ao consultar a API: " . curl_error($ch);
    } else {
        $statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if ($statusCode == 200) {
            $data = json_decode($response, true);
            if (json_last_error() === JSON_ERROR_NONE) {
                // Exibir dados da solicitação
                $solicitacao = $data['solicitacoes'];
                $imagens = $data['imagens'];
                $imagensArray = [];
                $imagensArray = $imagens;

                echo "<h1>Dados da Solicitação</h1>";
                echo "<p>ID da Solicitação: " . htmlspecialchars($solicitacao['idsolicitacao']) . "</p>";
                echo "<p>Observação: " . htmlspecialchars($solicitacao['observacao']) . "</p>";
                echo "<p>Usuário: " . htmlspecialchars($solicitacao['nome']) . "</p>";
                echo "<p>Serviço: " . htmlspecialchars($solicitacao['descricaoServico']) . "</p>";
                echo "<p>Unidade: " . htmlspecialchars($solicitacao['idUnidade']) . "</p>";
                echo "<p>Data de Abertura: " . $solicitacao['dataAbertura'] . "</p>";

                // Exibir imagens
                if (!empty($imagens)) {
                    echo "<h2>Documentos Anexados:</h2>";
                    echo "Qtd. imagens: " . count($imagens) ;
                    foreach ($imagens as $imagem) {
                        $tamanho = $imagem['size'] / 1048576;
                        $fileContent = $imagem['file'];
                        if (!empty($fileContent)) {
                            $imageType = $imagem['mimeType']; // Mime type correto
                            $convertedString = base64_decode($fileContent);
                            if ($imageType == "application/pdf") {
                                echo "<embed src='" . $convertedString . "' type='application/pdf' width='100%' height='1000' style='display: block; margin-bottom: 10px;' />";
                                echo "<p>Tamanho: " . number_format($tamanho, 2, '.', "") . " Mb</p>";

                            } else if (str_starts_with($convertedString, "data")) {
                                echo "<img src='" . $convertedString . "' alt='Imagem da Solicitação' style='max-width: 100%; display: block; margin-bottom: 10px;'/>";
                                echo "<p>Tamanho: " . number_format($tamanho, 2, '.', "") . " Mb</p>";
                            } else {
                                echo "<img src='data:" . $imageType . ";base64," . $convertedString . "' alt='Imagem da Solicitação' style='max-width: 100%; display: block; margin-bottom: 10px;'/>";
                                echo "<p>Tamanho: " . number_format($tamanho, 2, '.', "") . " Mb</p>";

                            }
                        } else {
                            echo "O conteúdo do arquivo está vazio.";
                        }
                    }
                } else {
                    echo "<p>Nenhuma imagem disponível.</p>";
                }
            } else {
                echo "Erro ao decodificar a resposta JSON.";
            }
        } else {
            echo "Erro na consulta. Código HTTP: " . $statusCode;
        }
    }

    // Fecha a sessão cURL
    curl_close($ch);
} else {
    echo "ID da Solicitação não fornecido.";
}
?>