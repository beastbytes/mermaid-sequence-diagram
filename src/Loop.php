<?php
/**
 * @copyright Copyright © 2024 BeastBytes - All rights reserved
 * @license BSD 3-Clause
 */

declare(strict_types=1);

namespace BeastBytes\Mermaid\SequenceDiagram;

final class Loop extends Block
{
    private const TYPE = 'loop';

    public function __construct(protected readonly string $description = '')
    {
        $this->type = self::TYPE;
        parent::__construct($description);
    }
}
