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
    private $expectedPlain;

    public function setUp(): void
    {
        $this->expectedStylish = readFile(getFixturePath('expected_stylish.txt'));
        $this->expectedPlain = readFile(getFixturePath('expected_plain.txt'));
        $this->expectedJson = readFile(getFixturePath('expected_json.txt'));
    }

    public function testGendiffJSON(): void
    {
        $beforeJSON = getFixturePath('before.json');
        $afterJSON = getFixturePath('after.json');
        
        $this->assertEquals(gendiff('stylish', $beforeJSON, $afterJSON), $this->expectedStylish);
        $this->assertEquals(gendiff('plain', $beforeJSON, $afterJSON), $this->expectedPlain);
        $this->assertEquals(gendiff('json', $beforeJSON, $afterJSON), $this->expectedJson);
    }

    public function testGendiffYAML(): void
    {
        $beforeYAML = getFixturePath('before.yaml');
        $afterYAML = getFixturePath('after.yaml');

        $this->assertEquals(gendiff('stylish', $beforeYAML, $afterYAML), $this->expectedStylish);
        $this->assertEquals(gendiff('plain', $beforeYAML, $afterYAML), $this->expectedPlain);
        $this->assertEquals(gendiff('json', $beforeYAML, $afterYAML), $this->expectedJson);
    }
}
