<?php

function qsm_test_check_passing_score() {
    // Создаем тестовые данные
    $quiz_id = 15; // Замените на ID вашей викторины
    $quiz_results = array(
        // Добавьте тестовые данные для результатов викторины
        'question_1' => true,
        'question_2' => false,
        'question_3' => true,
        // и т.д.
    );

    // Вызываем функцию проверки
    qsm_check_passing_score($quiz_results, $quiz_id);
}