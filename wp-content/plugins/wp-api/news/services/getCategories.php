<?php

require_once plugin_dir_path(__FILE__) . '/../../core/functions/getChildCategories.php';
require_once plugin_dir_path(__FILE__) . '/../dto/getCategories.dto.php';

function getCategories() {
	return getCategoriesDTO(getChildCategories(5));
}