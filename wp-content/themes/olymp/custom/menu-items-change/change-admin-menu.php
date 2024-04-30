<?php

final class Change_Admin_Menu {

    public static function init(): void {
        add_action( 'admin_menu', [ __CLASS__, 'change' ] );
    }

    public static function change() {
        global $menu;

        self::add_separator( 9 );
        self::add_separator( 70 );

        foreach( $menu as & $item ){
            // переименуем 'Внешний вид' в 'Тема'
            if( 'themes.php' === $item[2] ){
                $item[0] = __( 'Тема', 'km' );
            }

            // переименуем Плагины
            if( 'plugins.php' === $item[2] ){
                $item[0] = __( 'Плагины Сайта', 'km' );
            }
        }
        unset( $item );
    }

    /**
     * Добавляет разделитель в меню админки.
     * Проверяет наличие указанного индекса, если он есть увеличивает указанный индекс на 1.
     * Нужно это, чтобы не затереть существующие элементы меню, если указан одинаковый индекс.
     *
     * @param int $position Индекс, в какое место добавлять разделитель
     *
     * @author kama
     * @ver 1.0
     */
    protected static function add_separator( int $position ): void {
        global $menu;

        static $index;
        $index || ( $index = 1 );

        foreach( $menu as $mindex => $section ){

            if( $mindex >= $position ){

                while( isset( $menu[ $position ] ) ){
                    ++$position;
                }

                $menu[ $position ] = [
                    '',
                    'read',
                    "separator-my{$index}",
                    '',
                    'wp-menu-separator'
                ];

                $index++;

                break;
            }
        }

        ksort( $menu );
    }
}

//require get_template_directory() . '/custom/menu-customization/qualifying-stage.php';
//Change_Admin_Menu::init();