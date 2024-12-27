<?php namespace Kai\L5Swagger\Formatters;

use Kai\L5Swagger\Exceptions\ExtensionNotLoaded;

/**
 * Class AbstractFormatter
 * @package Kai\L5Swagger\Formatters
 */
abstract class AbstractFormatter {

    /**
     * Documentation array
     * @var array
     */
    protected array $documentation;

    /**
     * Formatter constructor.
     * @param array $documentation
     */
    public function __construct(array $documentation) {
        $this->documentation = $documentation;
    }

    /**
     * Format documentation
     * @return string
     * @throws ExtensionNotLoaded
     */
    abstract public function format(): string;

}
