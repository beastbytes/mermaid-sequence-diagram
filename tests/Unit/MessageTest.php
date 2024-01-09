<?php
/**
 * @copyright Copyright © 2024 BeastBytes - All rights reserved
 * @license BSD 3-Clause
 */

declare(strict_types=1);

use BeastBytes\Mermaid\SequenceDiagram\Arrow;
use BeastBytes\Mermaid\SequenceDiagram\Message;
use BeastBytes\Mermaid\SequenceDiagram\Participant;

const MESSAGE = 'Message text';

test('Message Test', function (Arrow $arrow) {
    $alice = new Participant('Alice');
    $bob = new Participant('Bob');

    $message = new Message($alice, $bob, MESSAGE, $arrow);

    expect($message->render(''))
        ->toBe('_Alice' . $arrow->value . '_Bob: ' . MESSAGE);
})
    ->with([
        Arrow::DottedLine,
        Arrow::DottedLineArrowhead,
        Arrow::DottedLineAsync,
        Arrow::DottedLineCross,
        Arrow::SolidLine,
        Arrow::SolidLineArrowhead,
        Arrow::SolidLineAsync,
        Arrow::SolidLineCross,
    ])
;
