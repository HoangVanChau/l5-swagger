<?php

namespace Kai\L5Swagger\Responses\SchemaBuilders;

use Illuminate\Support\Str;
use Kai\L5Swagger\Responses\SchemaBuilder;

/**
 * Class
 * @package Kai\L5Swagger\Responses\SchemaBuilders
 */
class LaravelApiErrorSchemaBuilder implements SchemaBuilder {

    /**
     * Build a schema for Laravel pagination
     *
     * @param  string|null  $modelRef  the swagger reference for model
     * @param  string|null  $uri  the current parsing uri
     *
     * @return array
     */
    public function build(string $modelRef =  null, string $uri =  null): array {
        if (!Str::startsWith($uri, '/')) {
            $uri = '/' . $uri;
        }
        $url = env('APP_URL') . $uri;
        return [
            'type' => 'object',
            'required' => [
                'data',
                'status',
                'message',
            ],
            'properties' => [
                "status" => [
                    'type' => 'bool',
                    'example' => true
                ],
                "message" => [
                    'type' => 'string',
                ],
                "data" => [
                    'type' => 'object',
                    '$ref' => $modelRef
                ],
            ]
        ];
    }

}
