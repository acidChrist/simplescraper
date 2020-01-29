<?php

namespace App\Service\VitecScrapper;

/**
 * Class is a simple value object
 * Returns value as a key => value array
 *
 * @package App\Service\VitecScrapper
 */
final class Value
{
    /**
     * @var
     */
    protected $name;

    /**
     * @var
     */
    protected $value;

    /**
     * Value constructor.
     * @param $name
     * @param $value
     */
    public function __construct($name, $value)
    {
        $this->name = $name;

        $this->value = $value;
    }

    /**
     * @return array
     */
    public function getValue(): array
    {
        return ['name' => $this->name, 'value' => $this->value];
    }
}