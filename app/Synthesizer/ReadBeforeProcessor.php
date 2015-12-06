<?php

namespace Reactor\Synthesizer;


use Kenarkose\Synthesizer\Processor\ProcessorInterface;

class ReadBeforeProcessor implements ProcessorInterface {

    const separator = '![READMORE]!';

    /**
     * @param string $value
     * @param mixed $args
     * @return string
     */
    public function process($value, $args = null)
    {
        $parts = explode(static::separator, $value);

        return current($parts);
    }
}