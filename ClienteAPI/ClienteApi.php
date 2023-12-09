<?php

use GuzzleHttp\Client as GuzzleCliente;

require 'vendor/autoload.php';

$cliente_API = new GuzzleCliente ([
    'base_uri' => "localhost: 8000"
]);


while (true) {
    echo "---------- Atendimento Medico -----------\n";
    echo "Escolha o que fazer:\n";
    echo "1 - Listar usuários\n";
    echo "2 - Cadastrar usuario\n";
    echo "3 - Listar um usuario\n";
    echo "4 - Deletar um usuario\n";
    echo "5 - Editar um usuario\n";
    echo "6 - Encerrar\n";
    $x = readline();//

    $array = array(
        "cpf" => "",
        "nome" => "",
        "data_nasc" => "",
        "tipo" => ""
    );

    if ($x == "1") {
        $resp = enviar_requisicao("$url_api/usuarios");
    
        if ($resp['codigo'] == 200) {
            $resp_json = json_decode($resp['corpo'], true);
    
            if ($resp_json === null) {
                echo "Erro ao decodificar JSON:\n";
                var_dump($resp['corpo']);
            } elseif (isset($resp_json['resultado']) && is_array($resp_json['resultado'])) {
                foreach ($resp_json['resultado'] as $item) {
                    echo $item['nome'] . "- " . $item['cpf'] . "\n";
                }
            } else {
                echo "Resposta da API não contém dados esperados:\n";
                var_dump($resp_json);
            }
        } else {
            echo "Erro na requisição (código {$resp['codigo']}): " . $resp['corpo'] . "\n";
        }
        
    }elseif ($x == "2") {

        echo "digite seu nome\n";
        $nome = readline();
        echo "digite seu cpf\n";
        $cpf = readline();
        echo "digite sua data de nascimento\n";
        $data_nasc = readline();
        echo "digite seu tipo\n";
        $tipo = readline();
        
        $array['nome'] = $nome;
        $array['cpf'] = $cpf;   
        $array['data_nasc'] = $data_nasc;   
        $array['tipo'] = $tipo;   

        $resp = enviar_requisicao("$url_api/usuarios", 
        metodo: 'POST',
        corpo: json_encode($array),
        cabecalhos: ['Content-type:application/json']
        );
    }

    
    elseif($x == 3) { 
            echo "digite o cpf: \n";
            $cpf = readline();

            $resp = $cliente_API->get("$url_api/usuarios/{$cpf}", [
                'headers' => ['Authorization' => "Bearer $this->suap_token"],
                'json' => $form
            ]);

            if($resp['codigo'] == "200"){
                $resp_json = json_decode($resp->getBody(), true);
            
                foreach($resp_json['resultado'] as $key => $value){
                    echo $key."- ". $value."\n";
                }
            }elseif($resp['codigo'] == "404"){
                echo "USUARIO NAO ENCONTRADO\n";
            }
            

    }
          
    elseif($x == 4){
        echo "---- DELETAR UM USUÁRIO ----\n";
        echo "digite o cpf: \n";
        $cpf = readline();
        $resp = $cliente_API->delete("$url_api/usuarios/{$cpf}", [
            'headers' => ['Authorization' => "Bearer $this->suap_token"],
            'json' => $form
        ]);

        if($resp['codigo'] == "200"){
        $resp = enviar_requisicao("$url_api/usuarios/{$cpf}", metodo:"DELETE");
        echo  "Usuário apagado\n";
        }
        else {echo "Usuário não existe\n";}

    }elseif($x == 5){
        
        echo "digite seu cpf\n";
        $cpfid = readline();
        $resp = $cliente_API->put("$url_api/usuarios/{$cpf}", [
            'headers' => ['Authorization' => "Bearer $this->suap_token"],
            'json' => $form
        ]);

        if($resp['codigo'] == "200"){
            echo "digite seu nome\n";
            $nome = readline();
            echo "digite seu cpf\n";
            $cpf = readline();
            echo "digite sua data de nascimento\n";
            $data_nasc = readline();
            echo "digite seu tipo\n";
            $tipo = readline();
            
            $array['nome'] = $nome;
            $array['cpf'] = $cpf;   
            $array['data_nasc'] = $data_nasc;   
            $array['tipo'] = $tipo;   
            
            $resp = $cliente_API->put("$url_api/usuarios/{$cpf}", [
                'headers' => ['Authorization' => "Bearer $this->suap_token"],
                'json' => $form
            ]);
            
            echo "Usuário Editado com sucesso!!\n";
        }else{
            echo"Usuário não existe\n";
        }

        
    }
    
    
    else{
        return false;
    }

    
    
}