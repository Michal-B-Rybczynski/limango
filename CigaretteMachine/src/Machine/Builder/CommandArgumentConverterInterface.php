<?php

namespace App\Machine\Builder;


/**
 * Interface CommandArgumentConverterInterface
 * @package App\Machine
 */
interface CommandArgumentConverterInterface
{
    /**
     * @param string $argument
     * @return mixed
     */
    public function convertToInt(string $argument);

    /**
     * @param string $argument
     * @return mixed
     */
    public function convertToFloat(string $argument);
}