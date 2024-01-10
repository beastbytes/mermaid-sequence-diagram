<?php
/**
 * @copyright Copyright © 2024 BeastBytes - All rights reserved
 * @license BSD 3-Clause
 */

declare(strict_types=1);

use BeastBytes\Mermaid\SequenceDiagram\Arrow;
use BeastBytes\Mermaid\SequenceDiagram\Block;
use BeastBytes\Mermaid\SequenceDiagram\Box;
use BeastBytes\Mermaid\SequenceDiagram\Message;
use BeastBytes\Mermaid\SequenceDiagram\Parallel;
use BeastBytes\Mermaid\SequenceDiagram\Participant;
use BeastBytes\Mermaid\SequenceDiagram\SequenceDiagram;

test('Sequence Diagram', function () {
    $alice = new Participant('A', 'Alice');
    $bob = new Participant('B', 'Bob');
    $caroline = new Participant('C', 'Caroline');
    $dave = new Participant('D', 'Dave');
    $elizabeth = new Participant('E', 'Elizabeth');

    $diagram = (new SequenceDiagram())
        ->withItem(
            (new Box('Box', [32,87,244]))
                ->withParticipant($alice, $bob)
            ,
            new Message($alice, $bob, 'Hello Bob', Arrow::SolidLineArrowhead),
            new Message($bob, $alice, 'Hello Alice', Arrow::SolidLineArrowhead)
        )
    ;

    expect($diagram->render())
        ->toBe("<pre class=\"mermaid\">\n"
               . "sequenceDiagram\n"
               . "  box rgb(32,87,244) Box\n"
               . "    participant _A as Alice\n"
               . "    participant _B as Bob\n"
               . "  end\n"
               . "  _A-&gt;&gt;_B: Hello Bob\n"
               . "  _B-&gt;&gt;_A: Hello Alice\n"
               . '</pre>'
        )
        ->and($diagram->addItem(
            $caroline,$dave,$elizabeth,
            (new Parallel())
                ->withBlock(
                    (new Block('Alice to Bob'))
                        ->withItem(
                            new Message($alice, $bob, 'Message AB', Arrow::SolidLineArrowhead)
                        )
                    ,
                    (new Block('Alice to Caroline'))
                        ->withItem(
                            new Message($alice, $caroline, 'Message AC', Arrow::SolidLineArrowhead),
                            (new Parallel())
                                ->withBlock(
                                    (new Block('Caroline to Dave'))
                                        ->withItem(
                                            new Message($caroline, $dave, 'Message CD', Arrow::SolidLineArrowhead)
                                        )
                                    ,
                                    (new Block('Caroline to Elizabeth'))
                                        ->withItem(
                                            new Message($caroline, $elizabeth, 'Message CE', Arrow::SolidLineArrowhead),
                                            (new Parallel())
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
        )
            ->render()
        )
        ->toBe("<pre class=\"mermaid\">\n"
               . "sequenceDiagram\n"
               . "  box rgb(32,87,244) Box\n"
               . "    participant _A as Alice\n"
               . "    participant _B as Bob\n"
               . "  end\n"
               . "  _A-&gt;&gt;_B: Hello Bob\n"
               . "  _B-&gt;&gt;_A: Hello Alice\n"
               . "  participant _C as Caroline\n"
               . "  participant _D as Dave\n"
               . "  participant _E as Elizabeth\n"
               . "  par Alice to Bob\n"
               . "    _A-&gt;&gt;_B: Message AB\n"
               . "  and Alice to Caroline\n"
               . "    _A-&gt;&gt;_C: Message AC\n"
               . "    par Caroline to Dave\n"
               . "      _C-&gt;&gt;_D: Message CD\n"
               . "    and Caroline to Elizabeth\n"
               . "      _C-&gt;&gt;_E: Message CE\n"
               . "      par Elizabeth to Dave\n"
               . "        _E-&gt;&gt;_D: Message ED\n"
               . "      and Elizabeth to Alice\n"
               . "        _E-&gt;&gt;_A: Message EA\n"
               . "      end\n"
               . "    end\n"
               . "  and Alice to Dave\n"
               . "    _A-&gt;&gt;_D: Message AD\n"
               . "  end\n"
               . '</pre>'
        )
    ;
});
