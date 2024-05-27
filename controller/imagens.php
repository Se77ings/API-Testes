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
                
                echo "<h1>Dados da Solicitação</h1>";
                echo "<p>ID da Solicitação: " . htmlspecialchars($solicitacao['idsolicitacao']) . "</p>";
                echo "<p>Observação: " . htmlspecialchars($solicitacao['observacao']) . "</p>";
                echo "<p>Usuário: " . htmlspecialchars($solicitacao['nome']) . "</p>";
                echo "<p>Serviço: " . htmlspecialchars($solicitacao['descricaoServico']) . "</p>";
                echo "<p>Unidade: " . htmlspecialchars($solicitacao['idUnidade']) . "</p>";
                echo "<p>Data de Abertura: " . htmlspecialchars($solicitacao['dataAbertura']) . "</p>";

                // Exibir imagens
                if (!empty($imagens)) {
                    echo "<h2>Imagens</h2>";
                    echo "Qtd. imagens: ". count($imagens);
                    foreach ($imagens as $imagem) {
                        $fileContent = $imagem['file'];
                        // Verifica se o conteúdo do arquivo é vazio
                        if (!empty($fileContent)) {
                            // Decodifica o conteúdo Base64
                            $decodedFileContent = base64_decode($fileContent);
                            // Verifica se a decodificação foi bem-sucedida
                            if ($decodedFileContent !== false) {
                                // Determina o tipo de conteúdo
                                $imageType = 'image/jpeg'; // ou 'image/png', dependendo do tipo de imagem
                                // Exibe a imagem
                                echo "<img src='data:" . $imageType . ";base64," . base64_encode($decodedFileContent) . "' alt='Imagem da Solicitação' style='max-width: 500px; display: block; margin-bottom: 10px;'/>";
                            } else {
                                echo "Erro ao decodificar o conteúdo da imagem.";
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
