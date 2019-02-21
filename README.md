# API Inema Clima-tempo
Uma API para consumir dados de temperatura, tempo e vento do banco de dados INEMA.

## Instalação
Instale primeiramente o banco de dados **postgrSQL** que contenha o bando de dados **meioambiente** seguindo a seguinte arquitetura:

- meioambiente (db)
  - painel_ambiental (schema)
    - localidades
    - previsaoclimatologica
    - tipoprevisao
    
Depois execute na pasta do projeto:
```bash
composer.phar start
```
Para modificar a porta padrão basta modificar o script *start* em *composer.json*

## Utilização
O App está configurado para receber apenas solicitações HTTP do tipo GET com as seguintes rotas
**/cidades**
```json
[
  {
    "idlocalidade": 214,
    "cod_ibge": "2900702",
    "nome": "Alagoinhas"
  }, /*...*/
]
```

**cidades/{id}**
```json
{
  "id": 199,
  "localidade": "Ilhéus",
  "previsoes": [
    {
    "tipo": {
        "id": 5,
        "previsao": "Chuvas fracas",
        "icone": "icone-condicoes-05.png"
      },
      "temperatura_min": 27,
      "temperatura_max": 35,
      "vento_direcao": null,
      "vento_max": null,
      "data_previsao": "2019-02-17"
    }, /*...*/
  ]
}
```
