<?php
function ifrs_editais_custom_queries( $query ) {
    if (!is_admin() && $query->is_main_query()) {
        if ($query->is_post_type_archive('edital') || $query->is_tax('edital_category')) {
            $query->set('posts_per_page', -1);
            $query->set('nopaging', true);
            $query->set('orderby', 'modified');
            $query->set('order', 'DESC');
        }
    }
}

add_action( 'pre_get_posts', 'ifrs_editais_custom_queries' );