<?php

namespace Kai\L5Swagger\Responses\SchemaBuilders;

use Illuminate\Support\Str;
use Kai\L5Swagger\Responses\SchemaBuilder;

/**
 * Class
 * @package Kai\L5Swagger\Responses\SchemaBuilders
 */
class LaravelApiPaginateSchemaBuilder implements SchemaBuilder {

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
                'meta',
            ],
            'properties' => [
                "status" => [
                    'type' => 'bool',
                    'example' => true
                ],
                "message" => [
                    'type' => 'string',
                ],
                "meta" => [
                    'type' => 'object',
                    'properties'=>[
                        "pagination" => [
                            'type' => 'object',
                            'required' => ['current_page', 'from', 'last_page', 'per_page', 'to', 'total'],
                            'properties' => [
                                "current_page" => [
                                    'type' => 'integer',
                                    'example' => 2
                                ],
                                "from" => [
                                    'type' => 'integer',
                                    'example' => 16
                                ],
                                "last_page" => [
                                    'type' => 'integer',
                                    'example' => 10
                                ],
                                "per_page" => [
                                    'type' => 'integer',
                                    'example' => 15
                                ],
                                "to" => [
                                    'type' => 'integer',
                                    'example' => 30
                                ],
                                "total" => [
                                    'type' => 'integer',
                                    'example' => 150
                                ],
                            ]
                        ],
                    ]
                ],
                "data" => [
                    'type' => 'array',
                    'items' => [
                        'type' => 'object',
                        '$ref' => $modelRef
                    ]
                ],
            ]
        ];
    }

}
