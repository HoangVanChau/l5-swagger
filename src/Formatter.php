<?php namespace Kai\L5Swagger;

use Kai\L5Swagger\Formatters\JsonFormatter;
use Kai\L5Swagger\Formatters\YamlFormatter;
use Kai\L5Swagger\Formatters\AbstractFormatter;
use Kai\L5Swagger\Exceptions\ExtensionNotLoaded;
use Kai\L5Swagger\Exceptions\InvalidFormatException;

/**
 * Class Formatter
 * @package Kai\L5Swagger
 */
class Formatter {

    /**
     * Documentation array
     * @var array
     */
    private array $documentation;

    /**
     * Formatter instance
     * @var AbstractFormatter
     */
    private AbstractFormatter $formatter;

    /**
     * Formatter constructor.
     * @param array $documentation
     */
    public function __construct(array $documentation) {
        $this->documentation = $documentation;
        $this->formatter = new JsonFormatter($this->documentation);
    }

    /**
     * Set desired output format
     * @param string $format
     * @return Formatter|static
     * @throws InvalidFormatException
     */
    public function setFormat(string $format): self {
        $format = strtolower($format);
        $this->formatter = $this->getFormatter($format);
        return $this;
    }

    /**
     * Get formatter instance
     * @param string $format
     * @return AbstractFormatter
     * @throws InvalidFormatException
     */
    protected function getFormatter(string $format): AbstractFormatter {
        switch ($format) {
            case 'json':
                return new JsonFormatter($this->documentation);
            case 'yaml':
                return new YamlFormatter($this->documentation);
            default:
                throw new InvalidFormatException('Invalid format specified');
        }
    }

    /**
     * Format documentation
     * @return mixed
     * @throws ExtensionNotLoaded
     */
    public function format() {
        return $this->formatter->format();
    }

}
