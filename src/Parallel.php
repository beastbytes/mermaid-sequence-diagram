<?php
/**
 * @copyright Copyright © 2024 BeastBytes - All rights reserved
 * @license BSD 3-Clause
 */

declare(strict_types=1);

namespace BeastBytes\Mermaid\SequenceDiagram;

final class Parallel extends BlockContainer
{
    protected function getType(int $i): string
    {
        return ($i === 0 ? 'par' : 'and');
    }

    /** @internal
    public function render(string $indentation): string
    {
        $output = [];

        foreach ($this->blocks as $i => $block) {
            $block->type = ($i === 0 ? 'par' : 'and');
            $output[] = $block->render($indentation);
        }

        $output[] = $indentation . 'end';

        return implode("\n", $output);
    } */
}
