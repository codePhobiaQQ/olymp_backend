<?php

// @dev функция отвечает за вывод контента страницы
// подробнее смотрите API Настроек: http://wp-kama.ru/id_3773/api-optsiy-nastroek.html

// MAIN - PAGE
function all_olymps_finishing_page_callback()
{
    ?>
    <div class="wrap">
        <h2><?php echo get_admin_page_title() ?></h2>
        <table class="widefat">
            <thead>
            <tr>
                <th>Тип олимпиады</th>
                <th>Дата начала</th>
                <th>Дата окончания</th>
                <th>Настройки</th>
            </tr>
            </thead>
            <tbody>
            <?php
            global $olymp_types;

            // Выводим каждый тип олимпиады и соответствующие ему даты начала, окончания и ссылку на страницу настроек
            foreach ($olymp_types as $type => $label) {
                $start_date = get_option('finishing_stage_start_date_' . $type);
                $end_date = get_option('finishing_stage_end_date_' . $type);

                ?>

                <tr>
                    <td><?php echo $label; ?></td>
                    <td><?php echo $start_date; ?></td>
                    <td><?php echo $end_date; ?></td>
                    <td><a href="<?php echo admin_url('admin.php?page=finishing-stage-' . $type); ?>">Настройки</a></td>
                </tr>
                <?php
            }
            ?>
            </tbody>
        </table>
    </div>
    <?php
}

/// --------------------
//  ---- OLYMP_PAGE ----
// ---------------------

// Получаем типы олимпиад из post-type "olymp_types"
function get_olymp_finishing_types() {
    $olymp_types = array();

    $args = array(
        'post_type'      => 'olymp',
        'posts_per_page' => -1,
    );

    $types_query = new WP_Query( $args );

    if ( $types_query->have_posts() ) {
        while ( $types_query->have_posts() ) {
            $types_query->the_post();
            $slug = get_post_field( 'slug' );
            $title = get_the_title();
            $olymp_types[$slug] = $title;
        }
        wp_reset_postdata();
    }

    return $olymp_types;
}
// Используем полученные типы олимпиад
$olymp_types = get_olymp_finishing_types();

// Callback функция для поля выбора квиза
function finishing_stage_quiz_field_render($args)
{
    $type = $args['type'];
    $selected_quiz = get_option('finishing_stage_quiz_' . $type);
    $quizzes = get_posts(array('post_type' => 'qsm_quiz')); // Замените на ваш тип квиза

    ?>
    <select name="finishing_stage_quiz_<?php echo $type; ?>" id="finishing_stage_quiz_<?php echo $type; ?>">
        <option value="">Выберите квиз</option>
        <?php foreach ($quizzes as $quiz) : ?>
            <option value="<?php echo $quiz->ID; ?>" <?php selected($selected_quiz, $quiz->ID); ?>><?php echo $quiz->post_title; ?></option>
        <?php endforeach; ?>
    </select>
    <?php
}

function finishing_stage_settings_init()
{
    global $olymp_types; // Используем глобальную переменную $olymp_types

    foreach ($olymp_types as $type => $label) {
        register_setting('finishing_stage_options_' . $type, 'finishing_stage_start_date_' . $type);
        register_setting('finishing_stage_options_' . $type, 'finishing_stage_end_date_' . $type);

        add_settings_section(
            'finishing_stage_section_' . $type,
            'Настройки олимпиады "' . $label . '"',
            'finishing_stage_section_callback',
            'finishing_stage_options_' . $type
        );

        add_settings_field(
            'finishing_stage_start_date_field_' . $type,
            'Дата начала олимпиады "' . $label . '"',
            'finishing_stage_start_date_field_render',
            'finishing_stage_options_' . $type,
            'finishing_stage_section_' . $type,
            array('type' => $type) // Передаем тип олимпиады в качестве аргумента
        );

        add_settings_field(
            'finishing_stage_end_date_field_' . $type,
            'Дата окончания олимпиады "' . $label . '"',
            'finishing_stage_end_date_field_render',
            'finishing_stage_options_' . $type,
            'finishing_stage_section_' . $type,
            array('type' => $type) // Передаем тип олимпиады в качестве аргумента
        );
    }
}

// Функция отображения секции настроек
function finishing_stage_section_callback()
{
    echo '<p>Выберите даты начала и окончания заключительного этапа олимпиады:</p>';
}

// Функция отображения поля для выбора даты начала
function finishing_stage_start_date_field_render($args)
{
    $type = $args['type'];
    $start_date = get_option('finishing_stage_start_date_' . $type);
    echo '<input type="date" name="finishing_stage_start_date_' . $type . '" value="' . esc_attr($start_date) . '" />';
}

// Функция отображения поля для выбора даты окончания
function finishing_stage_end_date_field_render($args)
{
    $type = $args['type'];
    $end_date = get_option('finishing_stage_end_date_' . $type);
    echo '<input type="date" name="finishing_stage_end_date_' . $type . '" value="' . esc_attr($end_date) . '" />';
}

// Функция отображения страницы настроек
function finishing_stage_options_page() {
    global $olymp_types; // Используем глобальную переменную $olymp_types

    $page_slug = isset($_GET['page']) ? sanitize_text_field($_GET['page']) : 'cryptography'; // Значение по умолчанию
    $type = str_replace('finishing-stage-', '', $page_slug); // Обрезаем префикс для получения типа олимпиады

    ?>
    <div class="wrap">
        <h2>Настройки олимпиады "<?php echo $olymp_types[$type] ?>"</h2>
        <form action="options.php" method="post">
            <?php
            settings_fields('finishing_stage_options_' . $type);
            do_settings_sections('finishing_stage_options_' . $type);
            submit_button('Сохранить', 'primary', 'submit', false); // Добавляем кнопку сохранения
            ?>
        </form>
    </div>
    <?php
}

function add_finishing_stage_menu_item()
{
    global $olymp_types; // Используем глобальную переменную $olymp_types

    $MENU_NAME = 'Заключительные этапы олимпиад';

    // Добавляем родительское меню
    add_menu_page($MENU_NAME, $MENU_NAME, 'manage_options', 'finishing-stage', 'all_olymps_finishing_page_callback');

    // Добавляем подменю для каждого типа олимпиады
    foreach ($olymp_types as $type => $label) {
        add_submenu_page(
            'finishing-stage', // Родительское меню
            'Заключительный этап олимпиады "' . $label . '"', // Заголовок страницы
            $label, // Название пункта меню
            'manage_options', // Уровень доступа
            'finishing-stage-' . $type, // Slug страницы
            'finishing_stage_options_page' // Callback функция для отображения содержимого страницы
        );
    }
}
