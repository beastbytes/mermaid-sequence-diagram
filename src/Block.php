<?php
/**
 * @copyright Copyright © 2024 BeastBytes - All rights reserved
 * @license BSD 3-Clause
 */

declare(strict_types=1);

namespace BeastBytes\Mermaid\SequenceDiagram;

use BeastBytes\Mermaid\CommentTrait;
use BeastBytes\Mermaid\RenderItemsTrait;

class Block implements ItemInterface
{
    use CommentTrait;
    use ItemTrait;
    use RenderItemsTrait;

    public const BLOCK_END = true;

    protected string $type = '';

    public function __construct(private readonly string $description = '')
    {
    }

    /** @internal */
    public function setType(string $type): self
    {
        $this->type = $type;
        return $this;
    }

    /** @internal */
    public function render(string $indentation): string
    {
        $output = [];
        $this->renderComment($indentation, $output);
        $this->renderBlock($indentation, $output, self::BLOCK_END);
        return implode("\n", $output);
    }

    /* @internal */
    public function renderBlock(string $indentation, array &$output, bool $end = false): void
    {
        $this->type .= ($this->description === '' ? '' : ' ' . $this->description);

        $output[] = $indentation . $this->type;
        $this->renderItems($this->items, $indentation, $output);

        if ($end) {
            $output[] = $indentation . 'end';
        }
    }
}
