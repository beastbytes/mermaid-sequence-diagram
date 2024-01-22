<?php
/**
 * @copyright Copyright © 2024 BeastBytes - All rights reserved
 * @license BSD 3-Clause
 */

declare(strict_types=1);

use BeastBytes\Mermaid\SequenceDiagram\Box;
use BeastBytes\Mermaid\SequenceDiagram\Participant;

test('Box Test', function () {
    $alice = new Participant('Alice');
    $bob = new Participant('Bob');
    $charlie = new Participant('Charlie');
    $dave = new Participant('Dave');

    $box = (new Box())
        ->withParticipant($alice, $bob)
    ;

    expect($box->render(''))
        ->toBe(
            "box\n"
            . "  participant _Alice as Alice\n"
            . "  participant _Bob as Bob\n"
            . "end"
        )
        ->and(
            $box->addParticipant($charlie, $dave)
                ->render('')
        )
        ->toBe(
            "box\n"
            . "  participant _Alice as Alice\n"
            . "  participant _Bob as Bob\n"
            . "  participant _Charlie as Charlie\n"
            . "  participant _Dave as Dave\n"
            . "end"
        )
        ->and(
            $box->withParticipant($charlie, $dave)
                ->render('')
        )
        ->toBe(
            "box\n"
            . "  participant _Charlie as Charlie\n"
            . "  participant _Dave as Dave\n"
            . "end"
        )
    ;
});

test('Box with description Test', function () {
    $alice = new Participant('Alice');
    $bob = new Participant('Bob');

    $box = (new Box('Description'))
        ->withParticipant($alice, $bob)
    ;

    expect($box->render(''))
        ->toBe(
            "box Description\n"
            . "  participant _Alice as Alice\n"
            . "  participant _Bob as Bob\n"
            . "end"
        )
    ;
});

test('Box with colour Test', function () {
    $alice = new Participant('Alice');
    $bob = new Participant('Bob');

    $box = (new Box('', [47, 153, 232]))
        ->withParticipant($alice, $bob)
    ;

    expect($box->render(''))
        ->toBe(
            "box rgb(47, 153, 232)\n"
            . "  participant _Alice as Alice\n"
            . "  participant _Bob as Bob\n"
            . "end"
        )
    ;
});

test('Box with description and colour Test', function () {
    $alice = new Participant('Alice');
    $bob = new Participant('Bob');

    $box = (new Box('Description', [47, 153, 232]))
        ->withParticipant($alice, $bob)
    ;

    expect($box->render(''))
        ->toBe(
            "box rgb(47, 153, 232) Description\n"
            . "  participant _Alice as Alice\n"
            . "  participant _Bob as Bob\n"
            . "end"
        )
    ;
});
