<?php
/**
 * @copyright Copyright © 2024 BeastBytes - All rights reserved
 * @license BSD 3-Clause
 */

declare(strict_types=1);

use BeastBytes\Mermaid\SequenceDiagram\Arrow;
use BeastBytes\Mermaid\SequenceDiagram\Breakk;
use BeastBytes\Mermaid\SequenceDiagram\Loop;
use BeastBytes\Mermaid\SequenceDiagram\Message;
use BeastBytes\Mermaid\SequenceDiagram\Opt;
use BeastBytes\Mermaid\SequenceDiagram\Participant;

defined('COMMENT') or define('COMMENT', 'comment');

test('Break, Loop, Option Test', function (string $blockClass, string $blockType) {
    $alice = new Participant('Alice');
    $bob = new Participant('Bob');

    $block = (new $blockClass())
        ->withItem(
            new Message($alice, $bob, 'Message one', Arrow::DottedLine),
            new Message($bob, $alice, 'Message two', Arrow::DottedLine)
        )
    ;

    expect($block->render(''))
        ->toBe(
            $blockType . "\n"
            . "  _Alice-->_Bob: Message one\n"
            . "  _Bob-->_Alice: Message two\n"
            . 'end'
        )
    ;

    $block = (new $blockClass('Description'))
        ->withItem(
            new Message($alice, $bob, 'Message one', Arrow::DottedLine),
            new Message($bob, $alice, 'Message two', Arrow::DottedLine)
        )
        ->withComment(COMMENT)
    ;

    expect($block->render(''))
        ->toBe(
            '%% ' . COMMENT . "\n"
            . $blockType . " Description\n"
            . "  _Alice-->_Bob: Message one\n"
            . "  _Bob-->_Alice: Message two\n"
            . 'end'
        )
    ;
})
    ->with([
        [Breakk::class, 'break'],
        [Loop::class, 'loop'],
        [Opt::class, 'opt'],
    ])
;
