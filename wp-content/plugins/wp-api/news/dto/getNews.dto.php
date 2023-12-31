<?php

function getNewsDTO( $posts ) {
	$news_data = array();

	foreach ($posts as $post) {
			$post_categories = get_the_category($post->ID);

			$category_ids = array();
				foreach ($post_categories as $category) {
						$category_ids[] = $category->term_id;
				}

			$news_item = array(
					'id' => $post->ID,

					'post_date' => $post->post_date,
					'post_modified' => $post->post_modified,
					'post_author' => $post->post_author,
					
					'post_title' => $post->post_title,
					'post_content' => $post->post_content,
					'create_time' => $post->post_content,

					'categories' => $category_ids,

					'news_title' => get_field('news_title', $post->ID),
					'news_description' => get_field('news_description', $post->ID),
					'news_preview_image' => get_field('news_preview_image', $post->ID),
			);

			$news_data[] = $news_item;
  }

  return $news_data;
  // return $posts;
}