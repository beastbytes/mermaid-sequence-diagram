<?php
/**
 * @copyright Copyright © 2024 BeastBytes - All rights reserved
 * @license BSD 3-Clause
 */

declare(strict_types=1);

use BeastBytes\Mermaid\SequenceDiagram\Actor;
use BeastBytes\Mermaid\SequenceDiagram\Participant;

test('Participant Test', function () {
    $alice = new Participant('Alice');

    expect($alice->getId())
        ->toBe('_Alice')
        ->and($alice->render(''))
        ->toBe('participant _Alice as Alice');
});

test('Participant with alias', function () {
    $alice = new Participant('A', 'Alice');

    expect($alice->getId())
        ->toBe('_A')
        ->and($alice->render(''))
        ->toBe('participant _A as Alice');
});

test('Actor Test', function () {
    $alice = new Actor('Alice');

    expect($alice)
        ->toBeInstanceOf(Participant::class)
        ->and($alice->getId())
        ->toBe('_Alice')
        ->and($alice->render(''))
        ->toBe('actor _Alice as Alice');
});

test('Actor with alias', function () {
    $alice = new Actor('A', 'Alice');

    expect($alice->getId())
        ->toBe('_A')
        ->and($alice->render(''))
        ->toBe('actor _A as Alice');
});

test('Activation Test', function () {
    $alice = new Participant('Alice');

    expect($alice->activate(''))
        ->toBe('activate _Alice');
});

test('Deactivation Test', function () {
    $alice = new Participant('Alice');

    expect($alice->deactivate(''))
        ->toBe('deactivate _Alice');
});
