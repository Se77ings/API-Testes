<?php

$url = "http://192.168.0.215:3000/solicitacoes/solicitacao/15";

// Initialize cURL
$curl = curl_init($url);

// Set cURL options
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

// Execute the request
$response = curl_exec($curl);

// Check for errors
if ($response === false) {
    echo "Error: " . curl_error($curl);
} else {
    // Echo the response
    // $imageDecoded = base64_decode($response);
    $response = json_decode($response);
    var_dump($response->imagens[0]->file);
    $imagemDecodificada = base64_decode($response->imagens[0]->file);
    echo $imagemDecodificada;
    // echo $response;
}

// Close cURL
curl_close($curl);

?>