<?php
/**
 * @copyright Copyright © 2024 BeastBytes - All rights reserved
 * @license BSD 3-Clause
 */

declare(strict_types=1);

namespace BeastBytes\Mermaid\SequenceDiagram;

use BeastBytes\Mermaid\RenderItemsTrait;
use InvalidArgumentException;

final class Box implements ItemInterface
{
    use RenderItemsTrait;

    private const TYPE = 'box';

    /** @psalm-var list<Participant> $participants */
    protected array $participants = [];

    private const MAX = 255;
    private const MIN = 0;

    /**
     * @param string $description
     * @psalm-param list<int, int, int> $colour
     * @param array $colour
     */
    public function __construct(private readonly string $description = '', private readonly array $colour = [])
    {
        if ($this->colour !== []) {
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
    }

    /** @psalm-suppress PropertyTypeCoercion */
    public function addParticipant(Participant ...$participant): self
    {
        $new = clone $this;
        $new->participants = array_merge($new->participants, $participant);
        return $new;
    }

    /** @psalm-suppress PropertyTypeCoercion */
    public function withParticipant(Participant ...$participant): self
    {
        $new = clone $this;
        $new->participants = $participant;
        return $new;
    }

    public function render(string $indentation): string
    {
        $output = [];

        $output[] = $indentation
            . self::TYPE
            . ($this->colour === [] ? '' : ' rgb(' . implode(',', $this->colour) . ')')
            . ($this->description === '' ? '' : ' ' . $this->description)
        ;
        $this->renderItems($this->participants, $indentation, $output);
        $output[] = $indentation . 'end';

        return implode("\n", $output);
    }
}
