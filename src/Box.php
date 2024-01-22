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

final class Box implements ItemInterface
{
    use ColourTrait;
    use CommentTrait;
    use RenderItemsTrait;

    private const TYPE = 'box';

    /** @psalm-var list<Participant> $participants */
    protected array $participants = [];

    public function __construct(private readonly string $description = '', private readonly array|string $colour = '')
    {
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

    /** @internal */
    public function render(string $indentation): string
    {
        $output = [];
        $this->renderComment($indentation, $output);
        $this->renderBlock($indentation, $output);
        return implode("\n", $output);
    }

    /* @internal */
    private function renderBlock(string $indentation, array &$output): void
    {
        $output[] = $indentation
            . self::TYPE
            . $this->parseColour($this->colour)
            . ($this->description === '' ? '' : ' ' . $this->description)
        ;
        $this->renderItems($this->participants, $indentation, $output);
        $output[] = $indentation . 'end';
    }
}
