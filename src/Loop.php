<?php
/**
 * @copyright Copyright © 2024 BeastBytes - All rights reserved
 * @license BSD 3-Clause
 */

declare(strict_types=1);

namespace BeastBytes\Mermaid\SequenceDiagram;

final class Loop extends Block
{
    protected const TYPE = 'loop';

    /** @internal */
    public function render(string $indentation): string
    {
        $output = [];

        $output[] = $this->renderBlock(self::TYPE, $indentation);
        $output[] = $indentation . 'end';

        return implode("\n", $output);
    }
}
