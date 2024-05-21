<?php

function getQuiz() {
    return do_shortcode('[qsm quiz=2]');
}

function getQualifyingStageTask($request)
{
    $olymp_slug = $request->get_param('olymp_slug');
    $quiz_id = get_option('qualifying_stage_quiz_' . $olymp_slug);
    // $quiz_content = get_post_field('post_content', $quiz_id);

    $quiz_content = do_shortcode('[qsm quiz=2]');

    // Используйте ob_start и ob_get_clean для формирования содержимого ответа
    ob_start();
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Quiz</title>
        <?php wp_head(); ?>
        <script>
            // Этот скрипт будет добавлять JWT токен к заголовкам всех AJAX запросов
            document.addEventListener('DOMContentLoaded', function() {
                const jwtToken = window.localStorage.getItem("user");

                // Используем fetch API и перехватываем запросы
                const originalFetch = window.fetch;
                window.fetch = async function(url, options = {}) {
                    options.headers = options.headers || {};
                    options.headers['Authorization'] = 'Bearer ' + jwtToken;
                    return originalFetch(url, options);
                };

                // Если используется jQuery
                if (window.jQuery) {
                    jQuery.ajaxSetup({
                        beforeSend: function(xhr) {
                            xhr.setRequestHeader('Authorization', 'Bearer ' + jwtToken);
                        }
                    });
                }
            });
        </script>
    </head>
    <body>
    <?php echo getQuiz(); ?>
    <div id='mountHere'></div>
    <?php wp_footer(); ?>
    </body>
    </html>
    <?php
    $content = ob_get_clean();

    return new WP_REST_Response(
        $content,
        200,
        array('Content-Type' => 'text/html; charset=UTF-8')
    );
}
