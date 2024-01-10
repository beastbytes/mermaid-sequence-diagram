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

    private const TYPE = 'rect';

    private const MAX = 255;
    private const MIN = 0;

    /**
     * @psalm-param list<int> $colour
     */
    public function __construct(private readonly array $colour)
    {
        $err = false;

        if (count($this->colour) !== 3) {
            $err = true;
        } else {
            foreach ($this->colour as $c) {
                if ($c < self::MIN || $c > self::MAX) {
                    break;
                }
            }
        }

        if ($err) {
            throw new InvalidArgumentException(
                sprintf(
                    '`$colour` must be an array of 3 integers (RGB), each between %s and %s inclusive',
                    self::MIN,
                    self::MAX
                )
            );
        }
    }

    /** @internal */
    public function render(string $indentation): string
    {
        $output = [];

        $output[] = $indentation . self::TYPE . ' rgb(' . implode(',', $this->colour) . ')';
        $output[] = $this->renderItems($this->items, $indentation);
        $output[] = $indentation . 'end';

        return implode("\n", $output);
    }
}
