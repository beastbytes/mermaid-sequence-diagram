<?php
/**
 * @copyright Copyright © 2024 BeastBytes - All rights reserved
 * @license BSD 3-Clause
 */

declare(strict_types=1);

use BeastBytes\Mermaid\SequenceDiagram\Arrow;
use BeastBytes\Mermaid\SequenceDiagram\Block;
use BeastBytes\Mermaid\SequenceDiagram\Critical;
use BeastBytes\Mermaid\SequenceDiagram\Message;
use BeastBytes\Mermaid\SequenceDiagram\Participant;

test('Critical Test', function () {
    $alice = new Participant('Alice');
    $bob = new Participant('Bob');
    $caroline = new Participant('Caroline');
    $charlie = new Participant('Charlie');
    $dave = new Participant('Dave');

    $message = 'Hello guys';

    $critical = (new Critical())
        ->withBlock(
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
            ,
        )
    ;

    expect($critical->render(''))
        ->toBe("critical Alice to Bob\n"
               . "  _Alice->>_Bob: Hello guys\n"
               . "option Alice to Charlie and Caroline\n"
               . "  _Alice->>_Charlie: Hello guys\n"
               . "  _Alice->>_Caroline: Hello guys\n"
               . "option Alice to Dave\n"
               . "  _Alice->>_Dave: Hello guys\n"
               . "end"
        )
    ;
});

test('Nested Critical Test', function () {
    $alice = new Participant('A', 'Alice');
    $bob = new Participant('B', 'Bob');
    $caroline = new Participant('C', 'Caroline');
    $dave = new Participant('D', 'Dave');
    $elizabeth = new Participant('E', 'Elizabeth');

    $critical = (new Critical())
        ->withBlock(
            (new Block('Alice to Bob'))
                ->withItem(
                    new Message($alice, $bob, 'Message AB', Arrow::SolidLineArrowhead)
                )
            ,
            (new Block('Alice to Caroline'))
                ->withItem(
                    new Message($alice, $caroline, 'Message AC', Arrow::SolidLineArrowhead),
                    (new Critical())
                        ->withBlock(
                            (new Block('Caroline to Dave'))
                                ->withItem(
                                    new Message($caroline, $dave, 'Message CD', Arrow::SolidLineArrowhead)
                                )
                            ,
                            (new Block('Caroline to Elizabeth'))
                                ->withItem(
                                    new Message($caroline, $elizabeth, 'Message CE', Arrow::SolidLineArrowhead),
                                    (new Critical())
                                        ->withBlock(
                                            (new Block('Elizabeth to Dave'))
                                                ->withItem(
                                                    new Message($elizabeth, $dave, 'Message ED', Arrow::SolidLineArrowhead)
                                                )
                                            ,
                                            (new Block('Elizabeth to Alice'))
                                                ->withItem(
                                                    new Message($elizabeth, $alice, 'Message EA', Arrow::SolidLineArrowhead)
                                                )
                                        )

                                )

                        )
                )
            ,
            (new Block('Alice to Dave'))
                ->withItem(
                    new Message($alice, $dave, 'Message AD', Arrow::SolidLineArrowhead)
                )
        )
    ;

    expect($critical->render(''))
        ->toBe("critical Alice to Bob\n"
               . "  _A->>_B: Message AB\n"
               . "option Alice to Caroline\n"
               . "  _A->>_C: Message AC\n"
               . "  critical Caroline to Dave\n"
               . "    _C->>_D: Message CD\n"
               . "  option Caroline to Elizabeth\n"
               . "    _C->>_E: Message CE\n"
               . "    critical Elizabeth to Dave\n"
               . "      _E->>_D: Message ED\n"
               . "    option Elizabeth to Alice\n"
               . "      _E->>_A: Message EA\n"
               . "    end\n"
               . "  end\n"
               . "option Alice to Dave\n"
               . "  _A->>_D: Message AD\n"
               . "end"
        )
    ;
});
