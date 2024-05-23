<?php
$url = '192.168.0.216:3000';
if ($_SERVER['REQUEST_METHOD'] === "GET") {

    $ch = curl_init($url . '/consultaBairro');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    curl_close($ch);

    // echo $response;

    $bairros = json_decode($response, true);
    foreach ($bairros as $bairro) {
        echo '<div class="option" id='.$bairro['id'].'>'.$bairro['nome'].'<input id="check'.$bairro['id'].'" type=checkbox disabled></div>';
    }
} 

?>