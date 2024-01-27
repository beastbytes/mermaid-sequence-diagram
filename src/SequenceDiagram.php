<?php
/**
 * @copyright Copyright © 2024 BeastBytes - All rights reserved
 * @license BSD 3-Clause
 */

declare(strict_types=1);

namespace BeastBytes\Mermaid\SequenceDiagram;

use BeastBytes\Mermaid\CommentTrait;
use BeastBytes\Mermaid\Mermaid;
use BeastBytes\Mermaid\MermaidInterface;
use BeastBytes\Mermaid\RenderItemsTrait;
use Stringable;

final class SequenceDiagram implements MermaidInterface, Stringable
{
    use CommentTrait;
    use ItemTrait;
    use RenderItemsTrait;

    private const TYPE = 'sequenceDiagram';

    public function __toString(): string
    {
        return $this->render();
    }

    public function render(array $attributes = []): string
    {
        $output = [];

        $this->renderComment('', $output);
        $output[] = self::TYPE;
        $this->renderItems($this->items, '', $output);

        return Mermaid::render($output, $attributes);
    }
}
