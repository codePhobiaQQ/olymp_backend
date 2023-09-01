<?php

function getCategoriesDTO( $categories ) {
	$categories_data = array();

	foreach ($categories as $category) {
			$category_item = array(
					'id' => $category->term_id,
					'name' => $category->name,
					'parent' => $category->parent
			);

			$categories_data[] = $category_item;
  }

  return $categories_data;
}