<?php

namespace Gendiff\Builder;

use Illuminate\Support\Collection;

function build(array $prevData, array $newData): array
{
    return collect(array_keys($prevData))
        ->merge(array_keys($newData))
        ->unique()
        ->sort()
        ->map(
            function ($key) use ($prevData, $newData) {
                $prevValue = $prevData[$key];
                $newValue = $newData[$key];
                if (!array_key_exists($key, $newData)) {
                    return [
                      'name' => $key,
                      'type' => 'deleted',
                      'value' => $prevValue
                    ];
                }
                if (!array_key_exists($key, $prevData)) {
                    return [
                      'name' => $key,
                      'type' => 'added',
                      'value' => $newValue
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
}
