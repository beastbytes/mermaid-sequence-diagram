<?php
/**
 * @copyright Copyright © 2024 BeastBytes - All rights reserved
 * @license BSD 3-Clause
 */

declare(strict_types=1);

use BeastBytes\Mermaid\SequenceDiagram\Arrow;
use BeastBytes\Mermaid\SequenceDiagram\Block;
use BeastBytes\Mermaid\SequenceDiagram\Par;
use BeastBytes\Mermaid\SequenceDiagram\Message;
use BeastBytes\Mermaid\SequenceDiagram\Participant;

test('Par Test', function () {
    $alice = new Participant('Alice');
    $bob = new Participant('Bob');
    $caroline = new Participant('Caroline');
    $charlie = new Participant('Charlie');
    $dave = new Participant('Dave');

    $message = 'Hello guys';

    $par = (new Par(
        (new Block('Alice to Bob'))
            ->withItem(
                new Message($alice, $bob, $message, Arrow::SolidLineArrowhead)
            )
        ,
        (new Block('Alice to Charlie and Caroline'))
            ->withItem(
                new Message($alice, $charlie, $message, Arrow::SolidLineArrowhead),
                new Message($alice, $caroline, $message, Arrow::SolidLineArrowhead)
            )
        ,
        (new Block('Alice to Dave'))
            ->withItem(
                new Message($alice, $dave, $message, Arrow::SolidLineArrowhead)
            )

    ));

    expect($par->render(''))
        ->toBe("par Alice to Bob\n"
            . "  _Alice->>_Bob: Hello guys\n"
            . "and Alice to Charlie and Caroline\n"
            . "  _Alice->>_Charlie: Hello guys\n"
            . "  _Alice->>_Caroline: Hello guys\n"
            . "and Alice to Dave\n"
            . "  _Alice->>_Dave: Hello guys\n"
            . "end"
        )
    ;
});

test('Nested Par Test', function () {
    $alice = new Participant('A', 'Alice');
    $bob = new Participant('B', 'Bob');
    $caroline = new Participant('C', 'Caroline');
    $dave = new Participant('D', 'Dave');
    $elizabeth = new Participant('E', 'Elizabeth');

    $par = (new Par(
        (new Block('Alice to Bob'))
            ->withItem(
                new Message($alice, $bob, 'Message AB', Arrow::SolidLineArrowhead)
            )
        ,
        (new Block('Alice to Caroline'))
            ->withItem(
                new Message($alice, $caroline, 'Message AC', Arrow::SolidLineArrowhead),
                (new Par(
                    (new Block('Caroline to Dave'))
                        ->withItem(
                            new Message($caroline, $dave, 'Message CD', Arrow::SolidLineArrowhead)
                        )
                    ,
                    (new Block('Caroline to Elizabeth'))
                        ->withItem(
                            new Message($caroline, $elizabeth, 'Message CE', Arrow::SolidLineArrowhead),
                            (new Par(
                                (new Block('Elizabeth to Dave'))
                                    ->withItem(
                                        new Message($elizabeth, $dave, 'Message ED', Arrow::SolidLineArrowhead)
                                    )
                                ,
                                (new Block('Elizabeth to Alice'))
                                    ->withItem(
                                        new Message($elizabeth, $alice, 'Message EA', Arrow::SolidLineArrowhead)
                                    )
                            ))
                        )
                ))
            )
        ,
        (new Block('Alice to Dave'))
            ->withItem(
                new Message($alice, $dave, 'Message AD', Arrow::SolidLineArrowhead)
            )
    ));

    expect($par->render(''))
        ->toBe("par Alice to Bob\n"
            . "  _A->>_B: Message AB\n"
            . "and Alice to Caroline\n"
            . "  _A->>_C: Message AC\n"
            . "  par Caroline to Dave\n"
            . "    _C->>_D: Message CD\n"
            . "  and Caroline to Elizabeth\n"
            . "    _C->>_E: Message CE\n"
            . "    par Elizabeth to Dave\n"
            . "      _E->>_D: Message ED\n"
            . "    and Elizabeth to Alice\n"
            . "      _E->>_A: Message EA\n"
            . "    end\n"
            . "  end\n"
            . "and Alice to Dave\n"
            . "  _A->>_D: Message AD\n"
            . "end"
        )
    ;
});
