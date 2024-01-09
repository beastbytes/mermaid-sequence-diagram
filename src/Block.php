<?php
/**
 * @copyright Copyright © 2024 BeastBytes - All rights reserved
 * @license BSD 3-Clause
 */

declare(strict_types=1);

namespace BeastBytes\Mermaid\SequenceDiagram;

use BeastBytes\Mermaid\RenderItemsTrait;

class Block extends ItemContainer
{
    use RenderItemsTrait;

    public function __construct(protected readonly string $description = '')
    {
    }

    /** @internal */
    public function renderBlock(string $type, string $indentation): string
    {
        $output = [];

        $output[] = $indentation . $type . ($this->description === '' ? '' : ' ' . $this->description);
        $output[] = $this->renderItems($this->items, $indentation);

        return implode("\n", $output);
    }
}
