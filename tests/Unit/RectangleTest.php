<?php
/**
 * @copyright Copyright © 2024 BeastBytes - All rights reserved
 * @license BSD 3-Clause
 */

declare(strict_types=1);

use BeastBytes\Mermaid\SequenceDiagram\Arrow;
use BeastBytes\Mermaid\SequenceDiagram\Block;
use BeastBytes\Mermaid\SequenceDiagram\Note;
use BeastBytes\Mermaid\SequenceDiagram\Parallel;
use BeastBytes\Mermaid\SequenceDiagram\Message;
use BeastBytes\Mermaid\SequenceDiagram\Participant;
use BeastBytes\Mermaid\SequenceDiagram\Position;
use BeastBytes\Mermaid\SequenceDiagram\Rectangle;

test('Rectangle Test', function () {
    $alice = new Participant('Alice');
    $bob = new Participant('Bob');
    $charlie = new Participant('Charlie');
    $dave = new Participant('Dave');

    $message = 'Hello guys';

    $rectangle = (new Rectangle(34, 102, 102))
        ->withItem(
            new Note('Note for Alice', Position::Left, $alice),
            new Message($alice, $bob, 'Hi Bob', Arrow::DottedLineCross),
            (new Parallel())
                ->withBlock(
                    (new Block('Parallel section'))
                        ->withItem(new Message($bob, $charlie, $message, Arrow::DottedLineArrowhead))
                    ,
                    (new Block('And section'))
                        ->withItem(new Message($bob, $dave, $message, Arrow::DottedLineArrowhead))
                )
        )
    ;

    expect($rectangle->render(''))
        ->toBe("rect rgb(34, 102, 102)\n"
            . "  note left of _Alice: Note for Alice\n"
            . "  _Alice--x_Bob: Hi Bob\n"
            . "  par Parallel section\n"
            . "    _Bob-->>_Charlie: Hello guys\n"
            . "  and And section\n"
            . "    _Bob-->>_Dave: Hello guys\n"
            . "  end\n"
            . "end"
        )
    ;
});

test('Nested Rectangle Test', function () {
    $alice = new Participant('A', 'Alice');
    $bob = new Participant('B', 'Bob');
    $charlie = new Participant('C', 'Charlie');
    $dave = new Participant('D', 'Dave');
    $elizabeth = new Participant('E', 'Elizabeth');

    $message = 'Hello guys';

    $rectangle = (new Rectangle(34, 102, 102))
        ->withItem(
            new Note('Note for Alice', Position::Left, $alice),
            new Message($alice, $bob, 'Hi Bob', Arrow::DottedLineCross),
            (new Parallel())
                ->withBlock(
                    (new Block('Parallel section'))
                        ->withItem(new Message($bob, $charlie, $message, Arrow::DottedLineArrowhead))
                    ,
                    (new Block('And section'))
                        ->withItem(new Message($bob, $dave, $message, Arrow::DottedLineArrowhead))
                )
            ,
            (new Rectangle(102, 34, 102))
                ->withItem(
                    new Message($dave, $elizabeth, 'Hi Elizabeth', Arrow::DottedLineCross),
                )
        )
    ;

    expect($rectangle->render(''))
        ->toBe("rect rgb(34, 102, 102)\n"
            . "  note left of _A: Note for Alice\n"
            . "  _A--x_B: Hi Bob\n"
            . "  par Parallel section\n"
            . "    _B-->>_C: Hello guys\n"
            . "  and And section\n"
            . "    _B-->>_D: Hello guys\n"
            . "  end\n"
            . "  rect rgb(102, 34, 102)\n"
            . "    _D--x_E: Hi Elizabeth\n"
            . "  end\n"
            . "end"
        )
    ;
});
