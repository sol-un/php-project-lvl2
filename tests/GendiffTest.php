<?php

namespace Differ\Tests;

use PHPUnit\Framework\TestCase;

use function Differ\Differ\gendiff;
use function Differ\Differ\readFile;

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

        $this->assertEquals(gendiff($beforeJSON, $afterJSON, 'stylish'), $this->expectedStylish);
        $this->assertEquals(gendiff($beforeJSON, $afterJSON, 'plain'), $this->expectedPlain);
        $this->assertEquals(gendiff($beforeJSON, $afterJSON, 'json'), $this->expectedJson);
    }

    public function testGendiffYAML(): void
    {
        $beforeYAML = getFixturePath('before.yaml');
        $afterYAML = getFixturePath('after.yaml');

        $this->assertEquals(gendiff($beforeYAML, $afterYAML, 'stylish'), $this->expectedStylish);
        $this->assertEquals(gendiff($beforeYAML, $afterYAML, 'plain'), $this->expectedPlain);
        $this->assertEquals(gendiff($beforeYAML, $afterYAML, 'json'), $this->expectedJson);
    }
}
