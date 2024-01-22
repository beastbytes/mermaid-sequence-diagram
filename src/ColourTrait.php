<?php
/**
 * @copyright Copyright © 2024 BeastBytes - All rights reserved
 * @license BSD 3-Clause
 */

declare(strict_types=1);

namespace BeastBytes\Mermaid\SequenceDiagram;

use InvalidArgumentException;

trait ColourTrait
{
    private function parseColour(array|string $colour): string
    {
        if (is_string($colour)) {
            return ($colour === '' ? '' : ' ' . $colour);
        }

        $invalid = false;

        if (count($colour) === 3 || count($colour) === 4) {
            for ($i = 0; $i < 3; $i++) {
                if ($colour[$i] < 0 || $colour[$i] > 255) {
                    $invalid = true;
                }
            }

            if (count($colour) === 4) {
                if ($colour[3] < 0 || $colour[3] > 1) {
                    $invalid = true;
                }
            }
        }

        if ($invalid) {
            throw new InvalidArgumentException(
        '`$colour` must be a string (HTML colour), or an array of 3 integers between 0 and 255 inclusive (RGB), or an array of 3 integers between 0 and 255 inclusive and a float between 0 and 1 inclusive (RGBA)'
            );
        }


        return ' rgb' . (count($colour) === 3 ? '' : 'a') . '(' . implode(', ', $colour) . ')';
    }
}
