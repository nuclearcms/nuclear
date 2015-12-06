<?php

namespace Reactor\Synthesizer;


use Kenarkose\Synthesizer\Processor\ProcessorInterface;

class ReadAllProcessor implements ProcessorInterface {

    const separator = '![READMORE]!';

    /**
     * @param string $value
     * @param mixed $args
     * @return string
     */
    public function process($value, $args = null)
    {
        return str_replace(static::separator, '', $value);
    }
}