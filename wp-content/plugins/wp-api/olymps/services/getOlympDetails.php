<?php

require_once plugin_dir_path(__FILE__) . '/../../core/functions/getChildPages.php';
require_once plugin_dir_path(__FILE__) . '/../../core/functions/getAcfPageData.php';
require_once plugin_dir_path(__FILE__) . '/../dto/getOlympsList.dto.php';
require_once plugin_dir_path(__FILE__) . './getOlympDetails.php';

function getOlympDetails($request)
{
    $olymp_slug = $request->get_param('olymp_slug');
    $olymp_list = getOlympsList();
    $result = null;

    foreach ($olymp_list as $olymp) {
        if (isset($olymp['ID']) && $olymp['slug'] === $olymp_slug) {
            $extra_data = get_fields($olymp['ID']);
            $result = array_merge($olymp, $extra_data);
            break;
        }
    }

    if ($result === null) {
        return new WP_Error('olymp_not_found', 'Olymp not found', array('status' => 404));
    }

    return $result;
}