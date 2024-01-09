<?php
/**
 * @copyright Copyright © 2024 BeastBytes - All rights reserved
 * @license BSD 3-Clause
 */

declare(strict_types=1);

namespace BeastBytes\Mermaid\SequenceDiagram;

use InvalidArgumentException;

final class Note implements ItemInterface
{
    private array $participants = [];

    public function __construct(
        private readonly string $note,
        private readonly Position $position,
        Participant ...$participant
    )
    {
        foreach ($participant as $p) {
            $this->participants[] = $p->getId();
        }

        if (count($this->participants) > 1 && $this->position !== Position::Over) {
            throw new InvalidArgumentException(
                '`position must be Position::Over when there is more than one participant'
            );
        }
    }

    /** @internal */
    public function render(string $indentation): string
    {
        return $indentation
            . 'note '
            . $this->position->value
            . ' ' . implode(',', $this->participants)
            . ': '
            . $this->note
        ;
    }
}
