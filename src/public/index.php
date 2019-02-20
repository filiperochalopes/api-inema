<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require '../../vendor/autoload.php';

$app = new \Slim\App;
$app->get('/cidades', function (Request $request, Response $response, array $args) {

    try{
        $myPDO = new PDO("pgsql:host=localhost;dbname=meioambiente", "postgres", "meioambiente");
        $myPDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $myPDO->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

        $sql_query = "SELECT idlocalidade, cod_ibge, nome FROM painel_ambiental.localidades ORDER BY nome ASC";
        // $sql_query = "SHOW TABLES";

        $sth = $myPDO->query($sql_query);
        // $sth->execute();

        $result = $sth->fetchAll(PDO::FETCH_ASSOC);
        $response = $response->withJson($result);

        return $response;

    }catch(PDOException $e){
        echo $e->getMessage();
    }
});

//Rota GET para captura dos dados para painel do tmepo pelo id da cidade
$app->get('/cidades/{cidade_id}', function (Request $request, Response $response, array $args) {
    $cidade_id = $args['cidade_id'];

    //Data de hoje para fins de teste, substituir depois pela função date() PHP
    $data_hoje = '2019-02-10';

    //Caso tenha algum id prossegue
    if($cidade_id){
        try{
            $myPDO = new PDO("pgsql:host=localhost;dbname=meioambiente", "postgres", "meioambiente");
            $myPDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $myPDO->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

            $sql_query = "SELECT idlocalidade, idtipoprevisao, temperaturamin, temperaturamax, ventodirecao, ventomax, dataprevisao FROM painel_ambiental.previsaoclimatologica WHERE deletado = false AND idlocalidade = $cidade_id AND dataprevisao >= '$data_hoje' ORDER BY dataprevisao ASC";

            echo $sql_query;

            $sth = $myPDO->query($sql_query);
            
            //Verifica se existe esse id no banco de dados
            if($sth->rowCount() > 0){
                /* estrutura:
                id: cidade_id,
                nome: nome da cidade,
                previsoes []
                */

            }else{
                
            }

            $result = $sth->fetchAll(PDO::FETCH_ASSOC);
            $response = $response->withJson($result);

            return $response;

        }catch(PDOException $e){
            echo $e->getMessage();
        }
    }else{

    }

    $response = $response->withJson($array);

    return $response;
});


$app->run();