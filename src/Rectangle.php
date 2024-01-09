<?php
/**
 * @copyright Copyright © 2024 BeastBytes - All rights reserved
 * @license BSD 3-Clause
 */

declare(strict_types=1);

namespace BeastBytes\Mermaid\SequenceDiagram;

use BeastBytes\Mermaid\RenderItemsTrait;
use InvalidArgumentException;

final class Rectangle extends ItemContainer implements ItemInterface
{
    use RenderItemsTrait;

    private const MAX = 255;
    private const MIN = 0;

    public function __construct(private readonly int $red, private readonly int $green, private readonly int $blue)
    {
        foreach (['red', 'green', 'blue'] as $colour) {
            if ($this->$colour < self::MIN || $this->$colour > self::MAX) {
                throw new InvalidArgumentException(
                    sprintf(
                        '`$red`, `$green`, and `$blue` must be integers between %s and %s inclusive',
                        self::MIN,
                        self::MAX
                    )
                );
            }
        }
    }

    /** @internal */
    public function render(string $indentation): string
    {
        $output = [];

        $output[] = $indentation . "rect rgb({$this->red}, {$this->green}, {$this->blue})";
        $output[] = $this->renderItems($this->items, $indentation);
        $output[] = $indentation . 'end';

        return implode("\n", $output);
    }
}
