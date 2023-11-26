<?php

require 'requisicoes.php';

// $resp = enviar_requisicao("$url_api/usuarios");

// var_dump($resp['codigo'], $resp['corpo']);

while(true){
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
        "nome"=> "",
        "data_nasc"=> "",
        "tipo"=> ""
      );

    if($x == "1"){
    
        $resp = enviar_requisicao("$url_api/usuarios");
        $resp_json = json_decode($resp['corpo'], true);
        foreach($resp_json['resultado'] as $item){
            echo $item['nome']."- ". $item['cpf']."\n";
        }
    
    }elseif($x == "2"){

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

            $resp = enviar_requisicao("$url_api/usuarios/{$cpf}");
            if($resp['codigo'] == "200"){
                $resp_json = json_decode($resp['corpo'], true);
            
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
        $resp = enviar_requisicao("$url_api/usuarios/{$cpf}", metodo:"HEAD");

        if($resp['codigo'] == "200"){
        $resp = enviar_requisicao("$url_api/usuarios/{$cpf}", metodo:"DELETE");
        echo  "Usuário apagado\n";
        }
        else {echo "Usuário não existe\n";}

    }elseif($x == 5){
        
        echo "digite seu cpf\n";
        $cpfid = readline();
        $resp = enviar_requisicao("$url_api/usuarios/{$cpfid}", metodo: 'HEAD');

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
            
            $resp = enviar_requisicao("$url_api/usuarios/{$cpfid}", 
            metodo: 'PUT',
            corpo: json_encode($array),
            cabecalhos: ['Content-type:application/json']
            );
            
            echo "Usuário Editado com sucesso!!\n";
        }else{
            echo"Usuário não existe\n";
        }

        
    }
    
    
    else{
        return false;
    }

    
    
}
