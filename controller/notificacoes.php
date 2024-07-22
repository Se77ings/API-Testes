<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $json_data = file_get_contents('php://input');
    $url = "192.168.0.216:3000/consultaBairro";
    //POST, JSON

    $data = json_decode($json_data, true);

    if ($data !== null) {
        $tipoNotificacao = isset($data['tipoNotificacao']) ? $data['tipoNotificacao'] : null;
        $corpoMensagem = isset($data['corpoMensagem']) ? $data['corpoMensagem'] : null;
        $notificaTodos = isset($data['notificaTodos']) ? $data['notificaTodos'] : null;
        $bairros = isset($data['bairros']) ? $data['bairros'] : null;

        $ch = curl_init($url);
        $data = array(
            'tipoNotificacao' => $tipoNotificacao,
            'corpoMensagem' => $corpoMensagem,
            'notificaTodos' => $notificaTodos,
            'idBairros' => $bairros
        );
        $payload = json_encode($data);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        if ($result === false) {
            echo "Erro no servidor!.";
        }

        curl_close($ch);
        echo $result;

    } else {
        echo "Erro ao enviar requisição.";
    }
}
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    echo "opa, bao fio?";
}
?>