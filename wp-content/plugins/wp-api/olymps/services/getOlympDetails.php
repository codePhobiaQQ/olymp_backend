<?php

require_once plugin_dir_path(__FILE__) . '/../../core/getChildPages.php';
require_once plugin_dir_path(__FILE__) . '/../../core/getAcfPageData.php';
require_once plugin_dir_path(__FILE__) . '/../dto/getOlympsList.dto.php';
require_once plugin_dir_path(__FILE__) . './getOlympDetails.php';

function getOlympDetails($request) {
    $olymp_link = $request->get_param('olymp_link');
    $olymp_list = getOlympsList($request);

    $result_olymp = null;

    foreach ($olymp_list as $olymp) {
        if (isset($olymp['olymp_link']) && $olymp['olymp_link'] === $olymp_link) {
            $result_olymp = $olymp;
            break;
        }
    }

    if ($result_olymp === null) {
        return new WP_Error('olymp_not_found', 'Olymp not found', array('status' => 404));
    }

    $page_id = $result_olymp['olymp_id'];

    return getAcfPageData($page_id);
}