<?php
/**
 * @copyright Copyright © 2024 BeastBytes - All rights reserved
 * @license BSD 3-Clause
 */

declare(strict_types=1);

namespace BeastBytes\Mermaid\SequenceDiagram;

final class Alternative extends BlockContainer
{
    protected function getType(int $i): string
    {
        return ($i === 0 ? 'alt' : 'else');
    }
}
