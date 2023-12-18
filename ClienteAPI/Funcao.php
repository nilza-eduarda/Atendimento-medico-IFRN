<?php

require 'vendor/autoload.php';
use GuzzleHttp\Client as GuzzleClient;


function login($matricula, $senha){
    $cliente_SUAP =  new GuzzleClient([
        'base_uri' => "https://suap.ifrn.edu.br"
    ]);

    $params = [
        'form_params' => [
            'username' => "",
            'password' => ""
        ]
    ];

    $params['form_params']['username'] = $matricula;
    $params['form_params']['password'] = $senha;

    $resp = $cliente_SUAP->post(
        '/api/v2/autenticacao/token/',
        $params
    );
    $resp_json = json_decode($resp->getBody(), true);

    return $resp_json['access'];
}