<?php
namespace clima\V1\Rest\Clima;

class ClimaResourceFactory
{
    public function __invoke($services)
    {
        return new ClimaResource();
    }
}
