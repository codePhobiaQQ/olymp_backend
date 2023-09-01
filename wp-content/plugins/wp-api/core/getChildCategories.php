<?php 

function getChildCategories($parent_category_id) {
    $child_categories = get_categories(array(
        'parent'     => $parent_category_id,
        'hide_empty' => false, // Включаем пустые рубрики
        'taxonomy'   => 'category', // Таксономия (рубрики)
    ));

    return $child_categories;
}