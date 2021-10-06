<?php

namespace Differ\Builder;

use Illuminate\Support\Collection;

function build(array $prevData, array $newData): array
{
    $ast = collect(array_keys($prevData))
        ->merge(array_keys($newData))
        ->unique()
        ->sort()
        ->map(
            function ($key) use ($prevData, $newData) {
                if (!array_key_exists($key, $newData)) {
                    return [
                        'name' => $key,
                        'type' => 'deleted',
                        'value' => $prevData[$key]
                    ];
                }
                if (!array_key_exists($key, $prevData)) {
                    return [
                        'name' => $key,
                        'type' => 'added',
                        'value' => $newData[$key]
                    ];
                }

                $prevValue = $prevData[$key];
                $newValue = $newData[$key];
                if (gettype($prevValue) === 'array' && gettype($newValue) === 'array') {
                    return [
                        'name' => $key,
                        'type' => 'nested',
                        'children' => build($prevValue, $newValue)
                    ];
                }
                if ($prevValue !== $newValue) {
                    return [
                        'name' => $key,
                        'type' => 'changed',
                        'prevValue' => $prevValue,
                        'newValue' => $newValue
                    ];
                }
                return [
                    'name' => $key,
                    'type' => 'unchanged',
                    'value' => $prevValue
                ];
            }
        )
        ->all();
    return $ast;
}
