<?php namespace Kai\L5Swagger\Responses;

/**
 * Interface SchemaBuilder
 * @package Kai\L5Swagger\Responses
 */
interface SchemaBuilder {

    /**
     * Build and return a custom swagger schema
     * @param string $modelRef a model swagger ref, (ex: #/components/schemas/User)
     * @param string $uri a current parsing uri
     * @return array an associative array representing the swagger schema for this resposne
     */
    public function build(string $modelRef, string $uri): array;

}
