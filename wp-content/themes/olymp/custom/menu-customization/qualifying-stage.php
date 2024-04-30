<?php

// -------------------------
// --------- MENU ----------
// -------------------------

// функция отвечает за вывод страницы настроек
// подробнее смотрите API Настроек: http://wp-kama.ru/id_3773/api-optsiy-nastroek.html
function add_my_setting(){
    ?>
    <div class="wrap">
        <h2><?php echo get_admin_page_title() ?></h2>

        <?php
        // settings_errors() не срабатывает автоматом на страницах отличных от опций
        if( get_current_screen()->parent_base !== 'options-general' )
            settings_errors('название_опции');
        ?>

        <form action="options.php" method="POST">
            <?php
            settings_fields("opt_group");     // скрытые защитные поля
            do_settings_sections("opt_page"); // секции с настройками (опциями).
            submit_button();
            ?>
        </form>
    </div>
    <?php
}

function add_qualifying_stage_page() {
//    add_menu_page( 'Отбророчный этап', 'Отбророчный этап', 'manage_options', 'site-options', 'add_my_setting', '', 100 );
    $MENU_NAME = 'Отбророчный этап';

    // ---------
    add_menu_page( $MENU_NAME, $MENU_NAME, 'manage_options', 'qualifying-stage' );
    add_submenu_page( 'qualifying-stage', $MENU_NAME, 'Олимпиады', 'manage_options', 'qualifying-stage', 'add_my_setting');
    add_submenu_page( 'qualifying-stage', 'Отборочной этап олимпиады "Криптогарфия"', 'Криптогарфия', 'manage_options', 'cryptography', 'page_callback_function');
}

// -------------------------
// -------- SUB_MENU -------
// -------------------------

