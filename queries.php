<?php
function ifrs_editais_custom_queries( $query ) {
    if (!is_admin() && $query->is_main_query()) {
        if ($query->is_post_type_archive('edital') || $query->is_tax('edital_category')) {
            $query->set('posts_per_page', -1);
            $query->set('nopaging', true);
            $query->set('orderby', 'modified');
            $query->set('order', 'DESC');

            $data_inicio = null;
            if (!empty($_POST['edital-data-inicio'])) {
                $data_inicio = date_create(sanitize_text_field($_POST['edital-data-inicio']));
                $data_inicio = ($data_inicio) ? date_format($data_inicio, 'U') : null;
            }

            $data_fim = null;
            if (!empty($_POST['edital-data-fim'])) {
                $data_fim = date_create(sanitize_text_field($_POST['edital-data-fim']));
                $data_fim = ($data_fim) ? date_format($data_fim, 'U') : null;
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
