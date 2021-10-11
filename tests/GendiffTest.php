<?php

namespace Differ\Tests;

use PHPUnit\Framework\TestCase;

use function Differ\Differ\genDiff;

function getFixturePath(string $filename): string
{
    return implode('/', ['tests', 'fixtures', $filename]);
}

class GendiffTest extends TestCase
{
    private $expectedStylishPath;
    private $expectedPlainPath;
    private $expectedJsonPath;

    public function setUp(): void
    {
        $this->expectedStylishPath = getFixturePath('expected_stylish.txt');
        $this->expectedPlainPath = getFixturePath('expected_plain.txt');
        $this->expectedJsonPath = getFixturePath('expected_json.txt');
    }

    public function testGendiffJSON(): void
    {
        $beforeJSON = getFixturePath('before.json');
        $afterJSON = getFixturePath('after.json');

        $this->assertStringEqualsFile($this->expectedStylishPath, genDiff($beforeJSON, $afterJSON, 'stylish'));
        $this->assertStringEqualsFile($this->expectedPlainPath, genDiff($beforeJSON, $afterJSON, 'plain'));
        $this->assertStringEqualsFile($this->expectedJsonPath, genDiff($beforeJSON, $afterJSON, 'json'));
    }

    public function testGendiffYAML(): void
    {
        $beforeYAML = getFixturePath('before.yaml');
        $afterYAML = getFixturePath('after.yaml');

        $this->assertStringEqualsFile($this->expectedStylishPath, genDiff($beforeYAML, $afterYAML, 'stylish'));
        $this->assertStringEqualsFile($this->expectedPlainPath, genDiff($beforeYAML, $afterYAML, 'plain'));
        $this->assertStringEqualsFile($this->expectedJsonPath, genDiff($beforeYAML, $afterYAML, 'json'));
    }
}
