<?php
/**
 * @copyright Copyright © 2024 BeastBytes - All rights reserved
 * @license BSD 3-Clause
 */

declare(strict_types=1);

namespace BeastBytes\Mermaid\SequenceDiagram;

final class Message implements ItemInterface
{
    public function __construct(
        private readonly Participant $sender,
        private readonly Participant $recipient,
        private readonly string $message,
        private readonly Arrow $arrow
    )
    {
    }

    /** @internal */
    public function render(string $indentation): string
    {
        return $indentation
            . $this->sender->getId()
            . $this->arrow->value
            . $this->recipient->getId()
            . ': '
            . $this->message
        ;
    }
}
