<?php
/**
 * @copyright Copyright © 2024 BeastBytes - All rights reserved
 * @license BSD 3-Clause
 */

declare(strict_types=1);

namespace BeastBytes\Mermaid\SequenceDiagram;

abstract class BlockContainer implements ItemInterface
{
    /** @psalm-var list<Block> $blocks */
    protected array $blocks = [];

    /** @psalm-suppress PropertyTypeCoercion */
    public function addBlock(Block ...$block): self
    {
        $new = clone $this;
        $new->blocks = array_merge($new->blocks, $block);
        return $new;
    }

    /** @psalm-suppress PropertyTypeCoercion */
    public function withBlock(Block ...$block): self
    {
        $new = clone $this;
        $new->blocks = $block;
        return $new;
    }

    /** @internal */
    public function render(string $indentation): string
    {
        $output = [];

        foreach ($this->blocks as $i => $block) {
            $output[] = $block->renderBlock($this->getType($i), $indentation);
        }

        $output[] = $indentation . 'end';

        return implode("\n", $output);
    }

    abstract protected function getType(int $i): string;
}
