<?php
namespace clima\V1\Rest\Cidade;

class CidadeResourceFactory
{
    public function __invoke($services)
    {
        return new CidadeResource();
    }
}
