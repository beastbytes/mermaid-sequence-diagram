<?php
/**
 * @copyright Copyright © 2024 BeastBytes - All rights reserved
 * @license BSD 3-Clause
 */

declare(strict_types=1);

namespace BeastBytes\Mermaid\SequenceDiagram;

enum Position: string
{
    case Left = 'left of';
    case Over = 'over';
    case Right = 'right of';
}
