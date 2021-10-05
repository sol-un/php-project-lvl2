<?php

namespace Gendiff\Formatters\Plain;

function renderValue($value): string
{
    switch (gettype($value)) {
        case "boolean":
            return $value ? "true" : "false";
        case "NULL":
            return "null";
        case "array":
            return "[complex value]";
        default:
            return "'{$value}'";
    }
}

function renderPath(array $parentNames, string $name): string
{
    return implode('.', [...$parentNames, $name]);
}

function getRenderFn($type)
{
    switch ($type) {
        case "nested":
            return function ($node, $parentNames, $render) {
                return $render($node["children"], [...$parentNames, $node["name"]]);
            };
        case "added":
            return function ($node, $parentNames) {
                $path = renderPath($parentNames, $node["name"]);
                $value = renderValue($node["value"]);
                return "Property '{$path}' was added with value: {$value}";
            };
        case "deleted":
            return function ($node, $parentNames) {
                $path = renderPath($parentNames, $node["name"]);
                return "Property '{$path}' was removed";
            };
        case "changed":
            return function ($node, $parentNames) {
                $path = renderPath($parentNames, $node["name"]);
                $prevValue = renderValue($node["prevValue"]);
                $newValue = renderValue($node["newValue"]);
                return "Property '{$path}' was updated. From {$prevValue} to {$newValue}";
            };
        case "unchanged":
            return fn() => null;
    }
}

function render(array $ast, array $parentNames = []): string
{
    return collect($ast)
        ->map(
            function ($node) use ($parentNames) {
                $type = $node["type"];
                return getRenderFn($type)($node, $parentNames, __NAMESPACE__ . '\\' . 'render');
            }
        )
        ->filter(fn($item) => $item)
        ->join("\n");
}

function renderPlain($ast): string
{
    return render($ast) . "\n";
}
