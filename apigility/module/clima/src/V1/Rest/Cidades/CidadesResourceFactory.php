<?php
namespace clima\V1\Rest\Cidades;

class CidadesResourceFactory
{
    public function __invoke($services)
    {
        return new CidadesResource();
    }
}
