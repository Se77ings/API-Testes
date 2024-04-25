<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $json_data = file_get_contents('php://input');
    $url= "192.168.0.215:3000/consultaBairro";
    //POST, JSON

    var_dump($json_data);

    $data = json_decode($json_data, true); 

    if ($data !== null) {
        $titulo = isset($data['titulo']) ? $data['titulo'] : null;
        $previsao = isset($data['previsao']) ? $data['previsao'] : null;
        $bairros = isset($data['bairros']) ? $data['bairros'] : null;
        $linkNoticia = isset($data['linkNoticia']) ? $data['linkNoticia'] : null;

        // echo "Titulo: " . $titulo . "<br>\nprevisao: " . $previsao . "<br>\nBairros: " . implode(', ', $bairros);

        $ch = curl_init($url);
        $data = array(
            'titulo' => $titulo,
            'previsao' => $previsao,
            'linkNoticia' =>$linkNoticia,
            'idBairros' => $bairros
        );
        $payload = json_encode($data);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        if($result === false) {
            echo "Erro no servidor!.";
        }

        curl_close($ch);
        echo $result;


    } else {
        echo "Erro ao enviar requisição.";
    }
}
?>