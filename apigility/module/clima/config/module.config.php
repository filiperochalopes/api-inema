<?php
return [
    'service_manager' => [
        'factories' => [
            \clima\V1\Rest\Cidades\CidadesResource::class => \clima\V1\Rest\Cidades\CidadesResourceFactory::class,
        ],
    ],
    'router' => [
        'routes' => [
            'clima.rest.cidades' => [
                'type' => 'Segment',
                'options' => [
                    'route' => '/cidades[/:cidade_id]',
                    'defaults' => [
                        'controller' => 'clima\\V1\\Rest\\Cidades\\Controller',
                    ],
                ],
            ],
        ],
    ],
    'zf-versioning' => [
        'uri' => [
            0 => 'clima.rest.cidades',
        ],
    ],
    'zf-rest' => [
        'clima\\V1\\Rest\\Cidades\\Controller' => [
            'listener' => \clima\V1\Rest\Cidades\CidadesResource::class,
            'route_name' => 'clima.rest.cidades',
            'route_identifier_name' => 'cidade_id',
            'collection_name' => 'cidades',
            'entity_http_methods' => [
                0 => 'GET',
            ],
            'collection_http_methods' => [
                0 => 'GET',
            ],
            'collection_query_whitelist' => [],
            'page_size' => 25,
            'page_size_param' => null,
            'entity_class' => \clima\V1\Rest\Cidades\CidadesEntity::class,
            'collection_class' => \clima\V1\Rest\Cidades\CidadesCollection::class,
            'service_name' => 'cidades',
        ],
    ],
    'zf-content-negotiation' => [
        'controllers' => [
            'clima\\V1\\Rest\\Cidades\\Controller' => 'HalJson',
        ],
        'accept_whitelist' => [
            'clima\\V1\\Rest\\Cidades\\Controller' => [
                0 => 'application/vnd.clima.v1+json',
                1 => 'application/hal+json',
                2 => 'application/json',
            ],
        ],
        'content_type_whitelist' => [
            'clima\\V1\\Rest\\Cidades\\Controller' => [
                0 => 'application/vnd.clima.v1+json',
                1 => 'application/json',
            ],
        ],
    ],
    'zf-hal' => [
        'metadata_map' => [
            \clima\V1\Rest\Cidades\CidadesEntity::class => [
                'entity_identifier_name' => 'id',
                'route_name' => 'clima.rest.cidades',
                'route_identifier_name' => 'cidade_id',
                'hydrator' => \Zend\Hydrator\ArraySerializable::class,
            ],
            \clima\V1\Rest\Cidades\CidadesCollection::class => [
                'entity_identifier_name' => 'id',
                'route_name' => 'clima.rest.cidades',
                'route_identifier_name' => 'cidade_id',
                'is_collection' => true,
            ],
        ],
    ],
];
