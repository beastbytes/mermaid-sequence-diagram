<?php
/**
 * @copyright Copyright © 2024 BeastBytes - All rights reserved
 * @license BSD 3-Clause
 */

declare(strict_types=1);

use BeastBytes\Mermaid\SequenceDiagram\Note;
use BeastBytes\Mermaid\SequenceDiagram\Participant;
use BeastBytes\Mermaid\SequenceDiagram\Position;

const NOTE = 'Note text';

test('Note Test', function (Position $position) {
    $alice = new Participant('Alice');

    $note = new Note(NOTE, $position, $alice);

    expect($note->render(''))
        ->toBe('note ' . $position->value . ' ' . $alice->getId() . ': ' . NOTE);
})
    ->with('positions')
;

test('Note with multiple participants', function (Position $position) {
    $alice = new Participant('Alice');
    $bob = new Participant('Bob');

    if ($position !== Position::Over) {
        expect(fn() => new Note(NOTE, $position, $alice, $bob))
            ->toThrow(
                InvalidArgumentException::class,
                '`position must be Position::Over when there is more than one participant'
            );
    } else {
        $note = new Note(NOTE, $position, $alice, $bob);

        expect($note->render(''))
            ->toBe('note over ' . $alice->getId() . ',' . $bob->getId() . ': ' . NOTE)
        ;
    }
})
    ->with('positions')
;

dataset('positions', [
    Position::Left,
    Position::Right,
    Position::Over,
]);
