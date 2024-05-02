<?php

function getChildPages($page_id) {
    return get_pages(array(
        'child_of' => $page_id,
    ));
}