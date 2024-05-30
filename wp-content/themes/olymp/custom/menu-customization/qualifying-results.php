<?php

// @dev функция отвечает за вывод контента страницы
// подробнее смотрите API Настроек: http://wp-kama.ru/id_3773/api-optsiy-nastroek.html

// MAIN - PAGE
function all_qualifying_results_callback()
{
    global $wpdb;

    // Define the academic year to filter by
    $academic_year = '[2023-2024]';

    // Get all quizzes (assumed to be a custom post type 'quiz')
    $quizzes = get_posts(array(
        'post_type' => 'qsm_quiz',
        'posts_per_page' => -1,
        's' => $academic_year, // Search for the academic year in the title
    ));

    print_r($quizzes);

    if (empty($quizzes)) {
        return new WP_Error('no_quizzes', 'No quizzes found for the specified academic year', array('status' => 404));
    }

    // Extract quiz IDs
    $quiz_ids = wp_list_pluck($quizzes, 'ID');
    if (empty($quiz_ids)) {
        return new WP_Error('no_quiz_ids', 'No quiz IDs found', array('status' => 404));
    }

    // Query to fetch quiz results for the obtained quiz IDs
    $placeholders = implode(',', array_fill(0, count($quiz_ids), '%d'));
    $results = $wpdb->get_results(
        $wpdb->prepare(
            "SELECT results.*, posts.post_title AS quiz_name
             FROM {$wpdb->prefix}mlw_results AS results
             JOIN {$wpdb->prefix}posts AS posts
             ON results.quiz_id = posts.ID
             WHERE results.quiz_id IN ($placeholders)",
            $quiz_ids
        )
    );

    if (empty($results)) {
        return new WP_Error('no_results', 'No quiz results found for the specified academic year', array('status' => 404));
    }

    print_r($results);

    ?>
    <div class="wrap">
        <h2><?php echo get_admin_page_title() ?></h2>
        <?echo $olymp; ?>
    </div>
    <?php
}

function add_qualifying_results_menu_item()
{
    $MENU_NAME = 'Результаты отборочных';
    // Добавляем родительское меню
    add_menu_page($MENU_NAME, $MENU_NAME, 'manage_options', 'qualifying-results', 'all_qualifying_results_callback');
}
