<?php
/**
 * @copyright Copyright © 2024 BeastBytes - All rights reserved
 * @license BSD 3-Clause
 */

declare(strict_types=1);

use BeastBytes\Mermaid\SequenceDiagram\Alternative;
use BeastBytes\Mermaid\SequenceDiagram\Arrow;
use BeastBytes\Mermaid\SequenceDiagram\Block;
use BeastBytes\Mermaid\SequenceDiagram\Message;
use BeastBytes\Mermaid\SequenceDiagram\Participant;

test('Alt Test', function () {
    $alice = new Participant('Alice');
    $bob = new Participant('Bob');

    $alternative = (new Alternative())
        ->withBlock(
            (new Block('If this, then'))
                ->withItem(
                    new Message($bob, $alice, 'Alt message one', Arrow::DottedLine),
                    new Message($alice, $bob, 'Alt message two', Arrow::DottedLine)
                )
            ,
            (new Block('Else if that, then'))
                ->withItem(
                    new Message($bob, $alice, 'Else message one', Arrow::DottedLine),
                    new Message($alice, $bob, 'Else message two', Arrow::DottedLine)
                )
            ,
            (new Block('Else'))
                ->withItem(
                    new Message($bob, $alice, 'Else 2 message one', Arrow::DottedLine),
                    new Message($alice, $bob, 'Else 2 message two', Arrow::DottedLine)
                )
        )
    ;

    expect($alternative->render(''))
        ->toBe(
            "alt If this, then\n"
            . "  _Bob-->_Alice: Alt message one\n"
            . "  _Alice-->_Bob: Alt message two\n"
            . "else Else if that, then\n"
            . "  _Bob-->_Alice: Else message one\n"
            . "  _Alice-->_Bob: Else message two\n"
            . "else Else\n"
            . "  _Bob-->_Alice: Else 2 message one\n"
            . "  _Alice-->_Bob: Else 2 message two\n"
            . 'end'
        )
    ;
});
