<?php

namespace Differ\Formatters\Json;

function renderJson(array $ast): string|false
{
    return json_encode($ast);
}
