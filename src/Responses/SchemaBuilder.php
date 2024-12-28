<?php namespace Kai\L5Swagger\Responses;

/**
 * Interface SchemaBuilder
 * @package Kai\L5Swagger\Responses
 */
interface SchemaBuilder {

    /**
     * Build and return a custom swagger schema
     *
     * @param  string|null  $modelRef  a model swagger ref, (ex: #/components/schemas/User)
     * @param  string|null  $uri  a current parsing uri
     *
     * @return array an associative array representing the swagger schema for this response
     */
    public function build(string $modelRef = null, string $uri = null): array;

}
