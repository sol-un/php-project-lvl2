<?php

namespace Gendiff\Formatters\Json;

function renderJson(array $ast): string
{
    return json_encode($ast) . "\n";
}
