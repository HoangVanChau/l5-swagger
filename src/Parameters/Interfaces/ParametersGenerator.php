<?php namespace Kai\L5Swagger\Parameters\Interfaces;

/**
 * Interface ParametersGenerator
 * @package Kai\L5Swagger\Parameters\Interfaces
 */
interface ParametersGenerator {

    /**
     * Get list of parameters
     * @return array
     */
    public function getParameters(): array;

    /**
     * Get parameter location
     * @return string
     */
    public function getParameterLocation(): string;

}
