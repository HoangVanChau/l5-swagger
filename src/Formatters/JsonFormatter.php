<?php namespace Kai\L5Swagger\Formatters;

use Kai\L5Swagger\Exceptions\ExtensionNotLoaded;

/**
 * Class JsonFormatter
 * @package Kai\L5Swagger\Formatters
 */
class JsonFormatter extends AbstractFormatter {

    /**
     * @inheritDoc
     * @return string
     * @throws ExtensionNotLoaded
     */
    public function format(): string {
        if (!extension_loaded('json')) {
            throw new ExtensionNotLoaded('JSON extends must be loaded to use the `json` output format');
        }
        return json_encode($this->documentation, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
    }

}
