<?php
/**
 * @copyright Copyright © 2024 BeastBytes - All rights reserved
 * @license BSD 3-Clause
 */

declare(strict_types=1);

namespace BeastBytes\Mermaid\SequenceDiagram;

use BeastBytes\Mermaid\CommentTrait;
use BeastBytes\Mermaid\RenderItemsTrait;
use InvalidArgumentException;

final class Rectangle extends Block
{
    use ColourTrait;
    use CommentTrait;
    use RenderItemsTrait;

    private const TYPE = 'rect';

    public function __construct(array|string $colour = '')
    {
        $this->type = self::TYPE . $this->parseColour($colour);
        parent::__construct();
    }
}
