<?php
/**
 * @copyright Copyright © 2024 BeastBytes - All rights reserved
 * @license BSD 3-Clause
 */

declare(strict_types=1);

namespace BeastBytes\Mermaid\SequenceDiagram;

final class Breakk extends Block
{
    protected const TYPE = 'break';

    public function __construct(string $description = '')
    {
        $this->type = self::TYPE;
        parent::__construct($description);
    }
}
