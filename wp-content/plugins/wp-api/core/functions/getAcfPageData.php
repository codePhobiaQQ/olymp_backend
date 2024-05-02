<?php

function getAcfPageData($page_id) {
    $acf_data = get_fields($page_id);
    return $acf_data;
}