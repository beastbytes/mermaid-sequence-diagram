<?php
/**
 * @copyright Copyright © 2024 BeastBytes - All rights reserved
 * @license BSD 3-Clause
 */

declare(strict_types=1);

namespace BeastBytes\Mermaid\SequenceDiagram;

use BeastBytes\Mermaid\CommentTrait;

class Participant implements ItemInterface
{
    use CommentTrait;

    public function __construct(protected readonly string $id, protected string $alias = '')
    {
        if ($this->alias === '') {
            $this->alias = $this->id;
        }
    }

    public function getId(): string
    {
        return '_' . $this->id;
    }

    public function activate(string $indentation): string
    {
        return $indentation . 'activate ' . $this->getId();
    }

    public function deactivate(string $indentation): string
    {
        return $indentation . 'deactivate ' . $this->getId();
    }

    /** @internal */
    public function render(string $indentation): string
    {
        $classname = get_class($this);
        $output = [];

        $this->renderComment($indentation, $output);
        $output[] = $indentation
            . strtolower(substr($classname, strrpos($classname, '\\') + 1))
            . ' '
            . $this->getId()
            . ' as '
            . $this->alias
        ;

        return implode("\n", $output);
    }
}
