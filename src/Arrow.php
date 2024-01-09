<?php
/**
 * @copyright Copyright © 2024 BeastBytes - All rights reserved
 * @license BSD 3-Clause
 */

declare(strict_types=1);

namespace BeastBytes\Mermaid\SequenceDiagram;

enum Arrow: string
{
    case DottedLine = '-->';
    case DottedLineArrowhead = '-->>';
    case DottedLineAsync = '--)';
    case DottedLineCross = '--x';
    case SolidLine = '->';
    case SolidLineArrowhead = '->>';
    case SolidLineAsync = '-)';
    case SolidLineCross = '-x';
}
