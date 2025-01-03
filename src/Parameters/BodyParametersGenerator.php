<?php namespace Kai\L5Swagger\Parameters;

use Exception;
use Illuminate\Support\Arr;
use Kai\L5Swagger\Parameters\Traits\GeneratesFromRules;
use Kai\L5Swagger\Parameters\Interfaces\ParametersGenerator;
use TypeError;

/**
 * Class BodyParametersGenerator
 * @package Kai\L5Swagger\Parameters
 */
class BodyParametersGenerator implements ParametersGenerator {
    use GeneratesFromRules;

    /**
     * Rules array
     * @var array
     */
    protected array $rules;

    /**
     * Parameters location
     * @var string
     */
    protected string $location = 'body';

    /**
     * BodyParametersGenerator constructor.
     * @param array $rules
     */
    public function __construct(array $rules) {
        $this->rules = $rules;
    }

    /**
     * Get parameters
     * @return array[]
     */
    public function getParameters(): array {
        $required = [];
        $properties = [];

        $schema = [];

        foreach ($this->rules as $parameter => $rule) {
            try {
                $parameterRules = $this->splitRules($rule);
                $nameTokens = explode('.', $parameter);
                $this->addToProperties($properties, $nameTokens, $parameterRules);

                if ($this->isParameterRequired($parameterRules)) {
                    $required[] = $parameter;
                }
            } catch (TypeError $e) {
                $ruleStr = json_encode($rule);
                throw new Exception("Rule `$parameter => $ruleStr` is not well formated", 0, $e);
            }
        }

        if (\count($required) > 0) {
            Arr::set($schema, 'required', $required);
        }

        Arr::set($schema, 'properties', $properties);

        $mediaType = 'application/json'; // or  "application/x-www-form-urlencoded"
        foreach($properties as $prop) {
            if ($prop['type'] === 'array') {
                $prop = $prop['items'];
            }
            if (isset($prop['format']) && $prop['format'] == 'binary') {
                $mediaType = 'multipart/form-data';
            }
        }

        Arr::set($schema, 'type', 'object');
        return [
            'content' =>  [
                $mediaType  =>  [
                    'schema' =>  $schema
                ]
            ]
        ];
    }

    /**
     * @inheritDoc
     * @return string
     */
    public function getParameterLocation(): string {
        return $this->location;
    }

    /**
     * Add data to properties array
     * @param array $properties
     * @param array $nameTokens
     * @param array $rules
     */
    protected function addToProperties(array & $properties, array $nameTokens, array $rules): void {
        if (\count($nameTokens) === 0) {
            return;
        }

        $name = array_shift($nameTokens);

        if (!empty($nameTokens)) {
            $type = $this->getNestedParameterType($nameTokens);
        } else {
            $type = $this->getParameterType($rules);
        }

        if ($name === '*') {
            if (!empty($properties) && !Arr::has($properties, 'properties')) {
                $propertyObject = $this->createNewPropertyObject($type, $rules);
                foreach ($propertyObject as $key => $value) {
                    Arr::set($properties, $key, $value);
                }
                $extra = $this->getParameterExtra($type, $rules);
                foreach($extra as $key => $value) {
                    Arr::set($properties, $key, $value);
                }
            } else {
                Arr::set($properties, 'type', $type);
            }

            if ($type === 'array') {
                $this->addToProperties($properties['items'], $nameTokens, $rules);
            } else if ($type === 'object' && isset($properties['properties'])) {
                $this->addToProperties($properties['properties'], $nameTokens, $rules);
            }
        } else {
            if (!Arr::has($properties, $name)) {
                $propertyObject = $this->createNewPropertyObject($type, $rules);
                Arr::set($properties, $name, $propertyObject);
                $extra = $this->getParameterExtra($type, $rules);
                foreach($extra as $key => $value) {
                    Arr::set($properties, $name . '.' . $key, $value);
                }
            } else {
                Arr::set($properties, $name . '.type', $type);
                if ((!isset($properties[$name]['properties']) && $type === 'object') || (!isset($properties[$name]['items']) && $type === 'array')) {
                    $propertyObject = $this->createNewPropertyObject($type, $rules);
                    Arr::set($properties, $name, $propertyObject);
                }
            }

            if ($type === 'array') {
                $this->addToProperties($properties[$name]['items'], $nameTokens, $rules);
            } else if ($type === 'object' && isset($properties[$name]['properties'])) {
                $this->addToProperties($properties[$name]['properties'], $nameTokens, $rules);
            }
        }
    }

    /**
     * Get nested parameter type
     * @param array $nameTokens
     * @return string
     */
    protected function getNestedParameterType(array $nameTokens): string {
        if (current($nameTokens) === '*') {
            return 'array';
        }
        return 'object';
    }

    /**
     * Create new property object
     * @param string $type
     * @param array $rules
     * @return string[]
     */
    protected function createNewPropertyObject(string $type, array $rules): array {
        $propertyObject = [
            'type' =>  $type,
        ];

        if ($enums = $this->getEnumValues($rules)) {
            Arr::set($propertyObject, 'enum', $enums);
        }

        if ($type === 'array') {
            Arr::set($propertyObject, 'items', [
                'description' => '',
            ]);
        } elseif ($type === 'object') {
            Arr::set($propertyObject, 'properties', [
                'description' => '',
            ]);
        }

        return $propertyObject;
    }
}

