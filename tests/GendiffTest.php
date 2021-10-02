<?php

namespace Gendiff\Tests;

use PHPUnit\Framework\TestCase;

use function Gendiff\Gendiff\gendiff;
use function Gendiff\Gendiff\readFile;

function getFixturePath(string $filename): string
{
    return "tests/fixtures/{$filename}";
}

class GendiffTest extends TestCase
{
    public function testGendiff(): void
    {
        $beforeJSON = getFixturePath('before.json');
        $afterJSON = getFixturePath('after.json');
        $expectedJSON = readFile(getFixturePath('expected_json.txt'));

        $this->assertEquals(gendiff($beforeJSON, $afterJSON), $expectedJSON);
    }
}
