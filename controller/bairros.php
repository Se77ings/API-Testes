<?php
$url = '192.168.0.216:3000';
if ($_SERVER['REQUEST_METHOD'] === "GET") {
    $ch = curl_init($url . '/consultaBairro');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    // Executa a requisição e fecha a sessão cURL
    $response = curl_exec($ch);
    curl_close($ch);

    // Decodifica a resposta JSON
    echo $response;
    $data = json_decode($response, true);


    // Verifica se a resposta contém os índices esperados
    // if (isset($data[0]) && isset($data[1])) {
    //     // Trata o índice 0
    //     $bairros = $data[0];
    //     foreach ($bairros as $bairro) {
    //         echo '<div class="option" id="' . $bairro['id'] . '">' . $bairro['nome'] . '<input id="check' . $bairro['id'] . '" type="checkbox" disabled></div>';
    //     }

    //     // Trata o índice 1
    //     $notificacoes = $data[1];
    //     foreach ($notificacoes as $notificacao) {
    //         echo '<div class="notification" id="notificacao' . $notificacao['idNotificacao'] . '">' . $notificacao['descricao'] . '</div>';
    //     }
    // }
}

?>