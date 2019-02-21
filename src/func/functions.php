<?php

function get_previsao($i, $array){
    foreach ($array as $key => $value) {
        if($value["idtipoprevisao"] == $i){
            return array(
                "id" => $value["idtipoprevisao"],
                "previsao" => $value["previsao"],
                "icone" => $value["icone"]
            );
        }
    }

    return array(
        "id" => $i,
        "mensagem" => "tipo de previsão não cadastrada"
    );
}