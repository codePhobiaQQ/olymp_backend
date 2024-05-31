<?php

// TODO: think how to make this mapping automatic
$quiz_categories = array(
    'cryptography' => 'Криптография',
    'mathematics' => 'Математика',
    'phys' => 'Физика',
    'chem' => 'Химия',
);

function getQuiz($quiz_id) {
    return do_shortcode('[qsm quiz=' . $quiz_id . ']');
}

function extract_variant_count($title) {
    if (preg_match('/\{(\d+)-(\d+)\}/', $title, $matches)) {
        return (int)$matches[2];
    }
    return 1;
}

function extract_quiz_id($content) {
    if (preg_match('/\[mlw_quizmaster\s+quiz=(\d+)\]/', $content, $matches)) {
        return (int)$matches[1];
    }
    return null;
}

function getQualifyingStageTask($request)
{
    global $quiz_categories;
    $olymp_slug = $request->get_param('olymp_slug');

    // Получаем категорию по olymp_slug
    $category_name = isset($quiz_categories[$olymp_slug]) ? $quiz_categories[$olymp_slug] : null;

    if (!$category_name) {
        return new WP_REST_Response('Некорректный olymp_slug.', 400);
    }

    // ------ Get Quizzes ------
    $args = array(
        'post_type' => 'qsm_quiz',
        'post_status' => 'publish',
        'numberposts' => -1
    );
    $quizzes = get_posts($args);

    // Фильтрация тестов по категории
    $filtered_quizzes = array_filter($quizzes, function($quiz) use ($category_name) {
        return strpos($quiz->post_title, $category_name) !== false;
    });

    // Если нет тестов для данной категории
    if (empty($filtered_quizzes)) {
        return new WP_REST_Response('Тест для данной категории не найден.', 404);
    }

    // ----- Validation of user metadata -----
    $current_user = wp_get_current_user();

    // Список необходимых метаданных
    $required_meta_keys = array('first_name', 'second_name', 'patronymic', 'school', 'grade');
    $missing_meta = array();

    foreach ($required_meta_keys as $key) {
        if (!get_user_meta($current_user->ID, $key, true)) {
            $missing_meta[] = $key;
        }
    }

    if (!empty($missing_meta)) {
        return new WP_REST_Response('Отсутствуют необходимые метаданные: ' . implode(', ', $missing_meta), 400);
    }

    // GETTING TASK VARIANT
    // $user_data_string = json_encode($current_user->data);
    $user_data_string = json_encode(array(
        'user_login' => $current_user->data->ID,
        'user_registered' => $current_user->data->user_registered,
    ));
    $hash = hash('sha256', $user_data_string);
    $hash_number = hexdec(substr($hash, 0, 8));

    // Определение количества вариантов для тестов в данной категории
    $variant_counts = array_map('extract_variant_count', wp_list_pluck($filtered_quizzes, 'post_title'));
    $max_variants = max($variant_counts);

    // Вычисление варианта для пользователя
    $variant = $hash_number % $max_variants;

    // Получение класса ученика
    $grade = get_user_meta($current_user->ID, 'grade', true);

    // Фильтрация тестов по вычисленному варианту и классу
    $selected_quiz = null;
    foreach ($filtered_quizzes as $quiz) {
        if (extract_variant_count($quiz->post_title) == $variant + 1 && strpos($quiz->post_title, "{{$grade}-") !== false) {
            $selected_quiz = $quiz;
            break;
        }
    }

    if (!$selected_quiz) {
        return new WP_REST_Response('Подходящий тест не найден.', 404);
    }

    $quiz_id = extract_quiz_id($selected_quiz->post_content);
    if (!$quiz_id) {
        return new WP_REST_Response('ID викторины не найден в содержимом поста.', 500);
    }

    ob_start();
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Quiz</title>
        <?php wp_head(); ?>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const jwtToken = window.localStorage.getItem("user");
                const originalFetch = window.fetch;
                window.fetch = async function(url, options = {}) {
                    options.headers = options.headers || {};
                    options.headers['Authorization'] = 'Bearer ' + jwtToken;
                    return originalFetch(url, options);
                };
                if (window.jQuery) {
                    jQuery.ajaxSetup({
                        beforeSend: function(xhr) {
                            xhr.setRequestHeader('Authorization', 'Bearer ' + jwtToken);
                        }
                    });
                }
            });
        </script>
    </head>
    <body>
    <?php echo getQuiz($quiz_id); ?>
    <div id='qualifying-stage'></div>
    <?php wp_footer(); ?>
    </body>
    </html>
    <?php
    $content = ob_get_clean();

    return new WP_REST_Response(
        $content,
        200,
        array('Content-Type' => 'text/html; charset=UTF-8')
    );
}