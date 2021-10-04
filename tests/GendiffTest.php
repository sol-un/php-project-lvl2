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
    private $expectedStylish;

    public function setUp(): void
    {
        $this->expectedStylish = readFile(getFixturePath('expected_stylish.txt'));
    }

    public function testGendiffJSON(): void
    {
        $beforeJSON = getFixturePath('before.json');
        $afterJSON = getFixturePath('after.json');

        $this->assertEquals(gendiff($beforeJSON, $afterJSON), $this->expectedStylish);
    }

    public function testGendiffYAML(): void
    {
        $beforeYAML = getFixturePath('before.yaml');
        $afterYAML = getFixturePath('after.yaml');

        $this->assertEquals(gendiff($beforeYAML, $afterYAML), $this->expectedStylish);
    }
}
