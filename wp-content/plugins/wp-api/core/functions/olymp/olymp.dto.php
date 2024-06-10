<?php

$quiz_name_slug = array(
    'Криптография' => 'cryptography',
    'Математика' => 'mathematics',
    'Физика' => 'phys',
    'Химия' => 'chem',
    'Информатика' => 'informatiс',
    'Информационная безопасность'  => 'information_security',
);

$quiz_slug_name = array(
    'cryptography' => 'Криптография',
    'mathematics' => 'Математика',
    'phys' => 'Физика',
    'chem' => 'Химия',
    'informatiс' => 'Информатика',
    'information_security' => 'Информационная безопасность',
);

function getAllOlympSlugs() {
    return ['cryptography', 'mathematics', 'phys', 'chem', 'informatiс', 'information_security'];
}

function getOlympSlugByName($name) {
    global $quiz_name_slug;
    return isset($quiz_name_slug[$name]) ? $quiz_name_slug[$name] : null;
}

function getOlympNameBySlug($slug) {
    global $quiz_slug_name;
    return isset($quiz_slug_name[$slug]) ? $quiz_slug_name[$slug] : null;
}