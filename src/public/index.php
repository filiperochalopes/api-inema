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

$app->get('/cidades/{cidade_id}', function (Request $request, Response $response, array $args) {
    $cidade_id = $args['cidade_id'];

    // $array = array(
    //     "id" => $cidade_id
    // );

    $data_hoje = '2019-02-08';
    if($cidade_id){
        try{
            $myPDO = new PDO("pgsql:host=localhost;dbname=meioambiente", "postgres", "meioambiente");
            $myPDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $myPDO->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

            $sql_query = "SELECT idlocalidade, temperaturamin, temperaturamax, ventodirecao, ventomax, dataprevisao FROM painel_ambiental.previsaoclimatologica WHERE deletado = false ORDER BY dataprevisao ASC";

            $sth = $myPDO->query($sql_query);

            $result = $sth->fetchAll(PDO::FETCH_ASSOC);
            $response = $response->withJson($result);

            return $response;

        }catch(PDOException $e){
            echo $e->getMessage();
        }
    }else{
        $resposta = array(
            
        )
    }

    $response = $response->withJson($array);

    return $response;
});


$app->run();