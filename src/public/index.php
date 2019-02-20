<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require '../../vendor/autoload.php';
// require '../config/db.php';

$app = new \Slim\App;
$app->get('/cidades', function (Request $request, Response $response, array $args) {

    try{
        $myPDO = new PDO("pgsql:host=localhost;dbname=meioambiente", "postgres", "meioambiente");
        $myPDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $myPDO->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

        $sql_query = "SELECT idlocalidade, nome FROM painel_ambiental.localidades ORDER BY nome ASC";
        // $sql_query = "SHOW TABLES";

        $sth = $myPDO->query("SET search_path TO painel_ambiental, public");
        $sth = $myPDO->query($sql_query);
        // $sth->execute();

        $result = $sth->fetchAll(PDO::FETCH_ASSOC);
        $response = $response->withJson($result);

        return $response;

    }catch(PDOException $e){
        echo $e->getMessage();
    }

    // $array = array(
    //     "nome" => "hoje",
    //     "time" => "oi"
    // );

    // $response = $response->withJson($array);

    // return $response;
});

$app->get('/cidades/{cidade_id}', function (Request $request, Response $response, array $args) {
    $cidade_id = $args['cidade_id'];
    $array = array(
        "id" => $cidade_id
    );

    $response = $response->withJson($array);

    return $response;
});


$app->run();