<?php

function register_olymp_post_type() {
    $labels = array(
        'name'                  => 'Олимпиады',
        'singular_name'         => 'Олимпиада',
        'add_new'               => 'Добавить новую',
        'add_new_item'          => 'Добавить новую олимпиаду',
        'edit_item'             => 'Редактировать олимпиаду',
        'new_item'              => 'Новая олимпиада',
        'view_item'             => 'Посмотреть олимпиаду',
        'view_items'            => 'Посмотреть олимпиады',
        'search_items'          => 'Найти олимпиаду',
        'not_found'             => 'Олимпиады не найдены',
        'not_found_in_trash'    => 'В корзине олимпиад не найдено',
        'parent_item_colon'     => 'Родительская олимпиада:',
        'all_items'             => 'Все олимпиады',
        'archives'              => 'Архивы олимпиад',
        'attributes'            => 'Атрибуты олимпиад',
        'insert_into_item'      => 'Вставить в олимпиаду',
        'uploaded_to_this_item' => 'Загружено к этой олимпиаде',
        'filter_items_list'     => 'Фильтровать список олимпиад',
        'items_list_navigation' => 'Навигация по списку олимпиад',
        'items_list'            => 'Список олимпиад',
    );
    $args = array(
        'public' => true,
        'label'  => 'Олимпиады',
        'labels' => $labels,
        'supports' => array( 'title',
//            'editor',
//            'excerpt',
            'custom-fields' ),
        'menu_position' => 100,
        'register_meta_box_cb' => 'add_olymp_metaboxes',
        'menu_icon'     => 'dashicons-awards'
    );

    register_post_type( 'olymp', $args );
}

function add_olymp_metaboxes() {
    add_meta_box(
        'olymp_info',
        'Информация о олимпиаде',
        'olymp_info_callback',
        'olymp',
        'normal',
        'default'
    );
}

function olymp_info_callback( $post ) {
    // Получаем значения метаполей
    $name = get_post_meta( $post->ID, 'name', true );
    $slug = get_post_meta( $post->ID, 'slug', true );
    $description = get_post_meta( $post->ID, 'description', true );

    // Выводим поля для ввода данных
    ?>
    <p><label for="name">Name:</label><br />
        <input type="text" id="name" name="name" value="<?php echo esc_attr( $name ); ?>" /></p>

    <p><label for="slug">Slug:</label><br />
        <input type="text" id="slug" name="slug" value="<?php echo esc_attr( $slug ); ?>" /></p>

    <p><label for="description">Description:</label><br />
        <?php
        // Проверяем, установлен ли Advanced Editor Tools
        if ( function_exists( 'advanced_editor_field' ) ) {
            advanced_editor_field(
                array(
                    'name' => 'description',
                    'value' => $description,
                    'settings' => array(
                        // Добавьте здесь настройки Advanced Editor Tools, если необходимо
                    )
                )
            );
        } else {
            // Если плагин не установлен, выводим обычное текстовое поле
            ?>
            <textarea id="description" name="description"><?php echo esc_textarea( $description ); ?></textarea>
            <?php
        }
        ?>
    </p>
    <?php
}

function save_olymp_meta( $post_id ) {
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }

    // Проверяем права доступа
    if ( ! current_user_can( 'edit_post', $post_id ) ) {
        return;
    }

    // Сохраняем значения метаполей
    if ( isset( $_POST['name'] ) ) {
        update_post_meta( $post_id, 'name', sanitize_text_field( $_POST['name'] ) );
    }
    if ( isset( $_POST['slug'] ) ) {
        update_post_meta( $post_id, 'slug', sanitize_text_field( $_POST['slug'] ) );
    }
    if ( isset( $_POST['description'] ) ) {
        update_post_meta( $post_id, 'description', wp_kses_post( $_POST['description'] ) );
    }
}