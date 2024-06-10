<?php

function getOlympDataByName($name) {
    // Извлекаем название олимпиады и год, игнорируя текст в фигурных скобках
    if (preg_match('/(.*?)(\s*\{.*?\})?\s*(\[\d{4}-\d{4}\])/', $name, $matches)) {
        $olymp_name = trim($matches[1]);
        $year = $matches[3];
    } else {
        $olymp_name = "Неизвестная олимпиада";
        $year = "Неизвестный год";
    }

    return [
        'olymp_name' => $olymp_name,
        'year' => $year
    ];
}