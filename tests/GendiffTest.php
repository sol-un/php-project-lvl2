<?php

namespace Differ\Tests;

use PHPUnit\Framework\TestCase;

use function Differ\Differ\gendiff;

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

        $this->assertStringEqualsFile($this->expectedStylishPath, gendiff($beforeJSON, $afterJSON, 'stylish'));
        $this->assertStringEqualsFile($this->expectedPlainPath, gendiff($beforeJSON, $afterJSON, 'plain'));
        $this->assertStringEqualsFile($this->expectedJsonPath, gendiff($beforeJSON, $afterJSON, 'json'));
    }

    public function testGendiffYAML(): void
    {
        $beforeYAML = getFixturePath('before.yaml');
        $afterYAML = getFixturePath('after.yaml');

        $this->assertStringEqualsFile($this->expectedStylishPath, gendiff($beforeYAML, $afterYAML, 'stylish'));
        $this->assertStringEqualsFile($this->expectedPlainPath, gendiff($beforeYAML, $afterYAML, 'plain'));
        $this->assertStringEqualsFile($this->expectedJsonPath, gendiff($beforeYAML, $afterYAML, 'json'));
    }
}
