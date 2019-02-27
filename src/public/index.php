<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require '../../vendor/autoload.php';
require '../func/functions.php';

// Instanciando novo App
$app = new \Slim\App;

//App para consumir a lista de todas as cidades disponíveis no banco de dados
$app->get('/cidades', function (Request $request, Response $response, array $args) {

    try{
        $myPDO = new PDO("pgsql:host=localhost;dbname=meioambiente", "postgres", "meioambiente");
        $myPDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $myPDO->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

        $sql_query = "SELECT idlocalidade, cod_ibge, nome FROM painel_ambiental.localidades ORDER BY nome ASC";

        $statement = $myPDO->query($sql_query);

        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        $response = $response->withJson($result);

        return $response;

    }catch(PDOException $e){
        return $response->withJson(array(
            "erro" => $e->getMessage()
        ));
    }
});

//Rota GET para captura dos dados para painel do tmepo pelo id da cidade, testar com Paulo Afonso 203 e Ilhéus 199
/*  Entrada: id da localidade
    Saída: {
        id: id,
        localidade: 'nome da localidade',
        previsoes: [ ...lista com previsões a partir de hoje ]
    }
*/
$app->get('/cidades/{cod_ibge}', function (Request $request, Response $response, array $args) {
    $cod_ibge = $args['cod_ibge'];

    //Data de hoje para fins de teste, substituir depois pela função date() PHP
    $today = '2019-02-10';

    //Caso tenha algum id prossegue
    if($cod_ibge){
        try{
            $myPDO = new PDO("pgsql:host=localhost;dbname=meioambiente", "postgres", "meioambiente");
            $myPDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $myPDO->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

            $result = array();

            // Query para criar array com tipos de previsao e armazenar em variavel
            $sql_query1 = "SELECT idtipoprevisao, previsao, icone FROM painel_ambiental.tipoprevisao WHERE deletado = false";
            $statement1 = $myPDO->query($sql_query1);
            $tipos_previsao = $statement1->fetchAll(PDO::FETCH_ASSOC);

            // Query para capturar o nome e id da localidade requerida
            // $sql_query2 = "SELECT idlocalidade, nome FROM painel_ambiental.localidades WHERE idlocalidade = $cod_ibge";
            // $statement2 = $myPDO->query($sql_query2);
            // if($statement2->rowCount() <= 0){
            //     return $response->withJson(array(
            //         "erro" => "Localidade não cadastrada em \"painel_ambiental.localidades\""
            //     ));
            // }
            // Caso exista a localidade adiciona os dados ao array
            // foreach ($statement2->fetchAll(PDO::FETCH_ASSOC) as $row) {
            //     $result["id"] = $row["idlocalidade"];
            //     $result["localidade"] = $row["nome"];
            // }

            $sql_query3 = "SELECT tipo_previsao, temperatura_min, temperatura_max, vento_direcao, vento_max, dtc_previsao FROM painel_ambiental.vw_previsaoclimatologica WHERE cod_ibge = '$cod_ibge' AND dtc_previsao >= '$today' ORDER BY dtc_previsao ASC";
            $statement3 = $myPDO->query($sql_query3);
            
            $result["previsoes"] = array();

            // Verifica se existe esse id no banco de dados e adiciona às previsoes
            if($statement3->rowCount() > 0){
                foreach ($statement3->fetchAll(PDO::FETCH_ASSOC) as $row) {
                    // Verifica tipo de previsao e adiciona um array associativo correspondente
                    // $tipo = get_previsao($row["idtipoprevisao"], $tipos_previsao);
                    $previsao = array(
                        "tipo" => $row["tipo_previsao"],
                        "temperatura_min" => $row["temperatura_min"],
                        "temperatura_max" => $row["temperatura_max"],
                        "vento_direcao" => $row["vento_direcao"],
                        "vento_max" => $row["vento_max"],
                        "data_previsao" => $row["dtc_previsao"],
                    );

                    array_push($result["previsoes"], $previsao);
                }

            }else{
                return $response->withJson(array(
                    "erro" => "Não existem previsões para esse id/localidade"
                ));
            }

            $response = $response->withJson($result);

            return $response;

        }catch(PDOException $e){
            return $response->withJson(array(
                "erro" => $e->getMessage()
            ));
        }
    }else{
        return $response->withJson(array(
            "erro" => "Parâmetro: \"código do ibge\" não passado"
        ));
    }

    $response = $response->withJson($array);

    return $response;
});


$app->run();