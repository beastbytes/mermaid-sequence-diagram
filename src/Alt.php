<?php
/**
 * @copyright Copyright © 2024 BeastBytes - All rights reserved
 * @license BSD 3-Clause
 */

declare(strict_types=1);

namespace BeastBytes\Mermaid\SequenceDiagram;

use BeastBytes\Mermaid\CommentTrait;

final class Alt implements ItemInterface
{
    use CommentTrait;

    private const TYPE = ['alt', 'else'];

    /** @var list<Block> $blocks */
    private array $blocks;

    public function __construct(Block ...$block)
    {
        $this->blocks = $block;
    }

    /** @internal */
    public function render(string $indentation): string
    {
        $output = [];
        $this->renderComment($indentation, $output);

        array_shift($this->blocks)
            ?->setType(self::TYPE[0])
            ->renderBlock($indentation, $output, count($this->blocks) === 0)
        ;

        $last = array_pop($this->blocks);

        foreach ($this->blocks as $block) {
            $block
                ->setType(self::TYPE[1])
                ->renderBlock($indentation, $output)
            ;
        }

        if ($last !== null) {
            $last
                ->setType(self::TYPE[1])
                ->renderBlock($indentation, $output, Block::BLOCK_END)
            ;
        }

        return implode("\n", $output);
    }
}
