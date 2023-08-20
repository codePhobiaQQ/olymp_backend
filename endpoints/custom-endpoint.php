<?php
add_action( 'rest_api_init', 'create_custon_endpoint' );

function create_custon_endpoint(){
    register_rest_route(
        'wp/v2',
        '/custom-ep',
        array(
            'methods' => 'GET',
            'callback' => 'get_response',
        )
    );
}
?>


<?php
function get_response() {
    // Your code...
    return 'This is your data!';
}
?>