<?php

namespace Kai\L5Swagger\Responses\SchemaBuilders;

use Illuminate\Support\Str;
use Kai\L5Swagger\Responses\SchemaBuilder;

/**
 * Class
 * @package Kai\L5Swagger\Responses\SchemaBuilders
 *
 */
class LaravelSimplePaginateSchemaBuilder implements SchemaBuilder {

    /**
     * Build a schema for Laravel simple pagination
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
            'required' => ['current_page', 'data', 'first_page_url', 'path', 'per_page'],
            'properties' => [
                "current_page" => [
                    'type' => 'integer',
                    'example' => 2
                ],
                "data" => [
                    'type' => 'array',
                    'items' => [
                        'type' => 'object',
                        '$ref' => $modelRef
                    ]
                ],
                "first_page_url" => [
                    'type' => 'string',
                    'example' => "$url?page=1"
                ],
                "from" => [
                    'type' => 'integer',
                    'example' => 16
                ],
                "next_page_url" => [
                    'type' => 'string',
                    'example' => "$url?page=3"
                ],
                "path" => [
                    'type' => 'string',
                    'example' => "$url"
                ],
                "per_page" => [
                    'type' => 'integer',
                    'example' => 15
                ],
                "prev_page_url" => [
                    'type' => 'string',
                    'example' => "$url?page=1"
                ],
                "to" => [
                    'type' => 'integer',
                    'example' => 30
                ],
            ]
        ];
    }

}
