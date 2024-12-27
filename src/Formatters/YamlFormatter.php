<?php namespace Kai\L5Swagger\Formatters;

use Kai\L5Swagger\Exceptions\ExtensionNotLoaded;

/**
 * Class YamlFormatter
 * @package Kai\L5Swagger\Formatters
 */
class YamlFormatter extends AbstractFormatter {

    /**
     * @inheritDoc
     * @return string
     * @throws ExtensionNotLoaded
     */
    public function format(): string {
        if (!extension_loaded('yaml')) {
            throw new ExtensionNotLoaded('YAML extends must be loaded to use the `yaml` output format');
        }
        return yaml_emit($this->documentation);
    }

}
