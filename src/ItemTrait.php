<?php
/**
 * @copyright Copyright © 2024 BeastBytes - All rights reserved
 * @license BSD 3-Clause
 */

declare(strict_types=1);

namespace BeastBytes\Mermaid\SequenceDiagram;

trait ItemTrait
{
    /** @psalm-var ItemInterface $items */
    protected array $items = [];

    protected function hasItems(): bool
    {
        return $this->items !== [];
    }

    /** @psalm-suppress PropertyTypeCoercion */
    public function addItem(ItemInterface ...$item): self
    {
        $new = clone $this;
        $new->items = array_merge($new->items, $item);
        return $new;
    }

    /** @psalm-suppress PropertyTypeCoercion */
    public function withItem(ItemInterface ...$item): self
    {
        $new = clone $this;
        $new->items = $item;
        return $new;
    }
}
