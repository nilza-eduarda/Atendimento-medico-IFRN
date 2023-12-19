<?php

require 'vendor/autoload.php';
require 'Funcao.php';
use GuzzleHttp\Client as GuzzleClient;

$cliente_API = new GuzzleClient ([
    'base_uri' => "localhost:8000"
]);

$cabecalho = array(
    "Content_type" => "application/json",
    "Authorization" => "Bearer "
);


while (true) {
    echo "---------- Atendimento Medico -----------\n";
    echo "Escolha o que fazer:\n";
    echo "1 - Login\n";
    echo "2 - Listar usuários\n";
    echo "3 - Cadastrar usuario\n";
    echo "4 - Listar um usuario\n";
    echo "5 - Deletar um usuario\n";
    echo "6 - Editar um usuario\n";
    echo "7 - Encerrar\n";
    $x = readline();//

    $array = array(
        "cpf" => "",
        "nome" => "",
        "data_nasc" => "",
        "tipo" => ""
    );

    if ($x == "1"){
        echo"---- LOGAR ----\n";
        echo "digite sua matricula\n";
        $matricula = readline();
        echo "digite sua senha\n";
        $senha = readline();
        $token = login($matricula, $senha);
        $cabecalho["Authorization"] = "Bearer $token";
        echo "Logado!\n";

    }
    
    else if ($x == "2") {
        
        echo"---- LISTAR USUÁRIOS ----\n";
        $resp = $cliente_API->get("/api/usuarios");
    
        if ($resp->getStatusCode() == 200) {
            $resp_json = json_decode($resp->getBody(), true);
    
            if ($resp_json === null) {
                echo "Erro ao decodificar JSON:\n";
                var_dump($resp->getBody());
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
        
    }elseif ($x == "3") {
        
        echo"---- CADASTRAR USUÁRIO ----\n";
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

        $resp = $cliente_API->post("/api/usuarios",[
            'headers' => $cabecalho,
            'json' => $array 
        ]);
        echo "Cadastrado!\n";
    }

    
    elseif($x == "4") { 
            
            echo"---- LISTAR UM USUÁRIO ----\n";
            echo "digite o cpf: \n";
            $cpf = readline();

            $resp = $cliente_API->get("/api/usuarios/{$cpf}", [
                'headers' => $cabecalho
            ]);

            if($resp->getStatusCode() == "200"){
                $resp_json = json_decode($resp->getBody(), true);
                echo "---- USUÁRIO ----\n";
                foreach($resp_json['resultado'] as $key => $value){
                    echo $key."- ". $value."\n";
                }
            }elseif($resp->getStatusCode() == "404"){
                echo "Usuário não encontrado\n";
            }
            

    }
          
    elseif($x == "5"){
        echo "---- DELETAR UM USUÁRIO ----\n";
        echo "digite o cpf: \n";
        $cpf = readline();
        $resp = $cliente_API->get("api/usuarios/{$cpf}", [
            'headers' => $cabecalho
        ]);

        if($resp->getStatusCode() == "200"){
        $resp = $cliente_API->delete("api/usuarios/{$cpf}", [
            'headers' => $cabecalho
        ]);
        echo  "Apagado!\n";
        }
        else {echo "Usuário não existe\n";}

    }elseif($x == "6"){
        
        echo"---- EDITAR UM USUÁRIO ----\n";
        echo "digite seu cpf\n";
        $cpfid = readline();
        $resp = $cliente_API->get("api/usuarios/{$cpfid}", [
            'headers' => $cabecalho
        ]);

        if($resp->getStatusCode() == "200"){
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
            
            $resp = $cliente_API->put("api/usuarios/{$cpfid}", [
                'headers' => $cabecalho,
                'json' => $array
            ]);
            
            echo "Editado!\n";
        }else{
            echo"Usuário não existe\n";
        }

        
    }
    
    
    else{
        return false;
    }


    
    
}

