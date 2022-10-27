<?php

namespace AppName\Domain\Entity;

use AppName\Domain\Collection\GenericCollection;

/**
 * @method Message current()
 */
final class MessageCollection extends GenericCollection
{
    public function __construct(
        iterable $elements,
        public readonly ?string $cursor = null,
    ) {
        parent::__construct(Message::class, $elements);
    }
}
