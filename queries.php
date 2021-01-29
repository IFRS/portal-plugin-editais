<?php
function ifrs_editais_custom_queries( $query ) {
    if (!is_admin() && $query->is_main_query()) {
        if ($query->is_post_type_archive('edital') || $query->is_tax('edital_category')) {
            $query->set('posts_per_page', -1);
            $query->set('nopaging', true);
            $query->set('orderby', 'modified');
            $query->set('order', 'DESC');

            $data_inicio = null;
            if ($_POST['edital-data-inicio']) {
                $data_inicio = date_format(date_create(sanitize_text_field($_POST['edital-data-inicio'])), 'U');
            }

            $data_fim = null;
            if ($_POST['edital-data-fim']) {
                $data_fim = date_format(date_create(sanitize_text_field($_POST['edital-data-fim'])), 'U');
            }

            if ($data_inicio || $data_fim) {
                if ($data_inicio && $data_fim) {
                    $value = array($data_inicio, $data_fim);
                    $compare = 'BETWEEN';
                } else if ($data_inicio && !$data_fim) {
                    $value = $data_inicio;
                    $compare = '>=';
                } else if ($data_fim && !$data_inicio) {
                    $value = $data_fim;
                    $compare = '<=';
                }
                $query->set('meta_query', array(
                    array(
                        'key'     => 'edital_date',
                        'value'   => $value,
                        'compare' => $compare,
                    ),
                ));
            }
        }
    }
}

add_action( 'pre_get_posts', 'ifrs_editais_custom_queries' );
