<?php
/**
 * @copyright Copyright © 2024 BeastBytes - All rights reserved
 * @license BSD 3-Clause
 */

declare(strict_types=1);

namespace BeastBytes\Mermaid\SequenceDiagram;

final class Critical extends BlockContainer
{
    protected function getType(int $i): string
    {
        return ($i === 0 ? 'critical' : 'option');
    }

    /** @internal
    public function render(string $indentation): string
    {
        $output = [];

        foreach ($this->items as $i => $item) {
            $item->type = ($i === 0 ? 'critical' : 'option');
            $output[] = $item->render($indentation);
        }

        $output[] = $indentation . 'end';

        return implode("\n", $output);
    } */
}
