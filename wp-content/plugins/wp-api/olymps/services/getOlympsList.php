<?php

require_once plugin_dir_path(__FILE__) . '/../../core/getChildPages.php';
require_once plugin_dir_path(__FILE__) . '/../dto/getOlympsList.dto.php';

function getOlympsList(): array {
    return getOlympsListDTO(getChildPages(228));
}