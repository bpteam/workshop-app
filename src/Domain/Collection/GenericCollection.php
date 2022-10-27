<?php

namespace AppName\Domain\Collection;

use Countable;
use InvalidArgumentException;
use Iterator;
use JsonSerializable;

abstract class GenericCollection extends Collection implements Iterator, Countable, JsonSerializable
{
    private string $typeName;

    protected function __construct(string $typeName, iterable $elements)
    {
        $this->typeName = $typeName;
        parent::__construct($elements);
    }

    public function current(): mixed
    {
        $current = parent::current();
        $this->validate($current);
        return $current;
    }

    private function validate($element): void
    {
        if (false === ($element instanceof $this->typeName)) {
            throw new InvalidArgumentException("Collection wait element with type {$this->typeName} had " . get_class($element));
        }
    }
}
