<?php
if ( ! function_exists('edital_post_type') ) {
    function edital_post_type() {
        $labels = array(
            'name'               => _x( 'Editais', 'Post Type General Name', 'ifrs-portal-plugin-editais' ),
            'singular_name'      => _x( 'Edital', 'Post Type Singular Name', 'ifrs-portal-plugin-editais' ),
            'menu_name'          => __( 'Editais', 'ifrs-portal-plugin-editais' ),
            'name_admin_bar'     => __( 'Editais', 'ifrs-portal-plugin-editais' ),
            'parent_item_colon'  => __( 'Edital principal:', 'ifrs-portal-plugin-editais' ),
            'all_items'          => __( 'Todos os Editais', 'ifrs-portal-plugin-editais' ),
            'add_new_item'       => __( 'Adicionar Novo Edital', 'ifrs-portal-plugin-editais' ),
            'add_new'            => __( 'Adicionar Novo', 'ifrs-portal-plugin-editais' ),
            'new_item'           => __( 'Novo Edital', 'ifrs-portal-plugin-editais' ),
            'edit_item'          => __( 'Editar Edital', 'ifrs-portal-plugin-editais' ),
            'update_item'        => __( 'Atualizar Edital', 'ifrs-portal-plugin-editais' ),
            'view_item'          => __( 'Ver Edital', 'ifrs-portal-plugin-editais' ),
            'search_items'       => __( 'Buscar Edital', 'ifrs-portal-plugin-editais' ),
            'not_found'          => __( 'Não encontrado', 'ifrs-portal-plugin-editais' ),
            'not_found_in_trash' => __( 'Não encontrado na Lixeira', 'ifrs-portal-plugin-editais' ),
        );
        $capabilities = array(
			// meta caps (don't assign these to roles)
			'edit_post'              => 'edit_edital',
			'read_post'              => 'read_edital',
			'delete_post'            => 'delete_edital',

			// primitive/meta caps
			'create_posts'           => 'create_editais',

			// primitive caps used outside of map_meta_cap()
			'edit_posts'             => 'edit_editais',
			'edit_others_posts'      => 'edit_editais',
			'publish_posts'          => 'publish_editais',
			'read_private_posts'     => 'read',

			// primitive caps used inside of map_meta_cap()
			'read'                   => 'read',
			'delete_posts'           => 'delete_editais',
			'delete_private_posts'   => 'delete_editais',
			'delete_published_posts' => 'delete_editais',
			'delete_others_posts'    => 'delete_editais',
			'edit_private_posts'     => 'edit_editais',
			'edit_published_posts'   => 'edit_editais',
		);
        $args = array(
            'label'               => __( 'edital', 'ifrs-portal-plugin-editais' ),
            'description'         => __( 'Editais', 'ifrs-portal-plugin-editais' ),
            'labels'              => $labels,
            'supports'            => array( 'title', 'editor', 'revisions' ),
            'taxonomies'          => array( 'edital_category' ),
            'hierarchical'        => false,
            'public'              => true,
            'show_ui'             => true,
            'show_in_menu'        => true,
            'show_in_nav_menus'   => true,
            'show_in_admin_bar'   => true,
            'menu_position'       => 10,
            'menu_icon'           => 'dashicons-media-text',
            'can_export'          => true,
            'has_archive'         => true,
            'exclude_from_search' => false,
            'publicly_queryable'  => true,
            'capability_type'     => array( 'edital', 'editais' ),
            'map_meta_cap'        => true,
            'capabilities'        => $capabilities,
            'rewrite'             => array( 'slug' => 'editais' ),
        );
        register_post_type( 'edital', $args );
    }

    add_action( 'init', 'edital_post_type', 1 );
}

// MetaBox
function editais_meta_boxes( $meta_boxes ) {
    $meta_boxes[] = array(
        'title'      => __( 'Dados do Edital', 'ifrs-portal-plugin-editais' ),
        'post_types' => 'edital',
        'fields'     => array(
            // array(
            //     'id'             => 'edital_number',
            //     'name'           => __( 'Número de Publicação', 'ifrs-portal-plugin-editais' ),
            //     'desc'           => __( 'Insira o número oficial do edital.', 'ifrs-portal-plugin-editais' ),
            //     'type'           => 'text',
            //     'size'           => 5,
            //     'attributes'     => array(
            //         'required'   => true,
            //         'pattern'    => '\d*',
            //     ),

            // ),
            array(
                'id'             => 'edital_date',
                'name'           => __( 'Data de Publicação', 'ifrs-portal-plugin-editais' ),
                'desc'           => __( 'Selecione a data de publicação oficial do Edital', 'ifrs-portal-plugin-editais' ),
                'type'           => 'date',
                'timestamp'      => true,
                'js_options'     => array(
                    'dateFormat' => 'dd/mm/yy'
                ),
                'attributes'     => array(
                    'required'   => true,
                ),

            ),
        )
    );
    $meta_boxes[] = array(
        'title'      => __( 'Arquivos Associados', 'ifrs-portal-plugin-editais' ),
        'post_types' => 'edital',
        'fields'     => array(
            array(
                'id'               => 'edital_file',
                'name'             => __( 'Edital', 'ifrs-portal-plugin-editais' ),
                'desc'             => __( 'Envio do Edital original', 'ifrs-portal-plugin-editais' ),
                'type'             => 'file_advanced',
                'max_file_uploads' => 1,
            ),
            array(
                'id'               => 'edital_retifica_files',
                'name'             => __( 'Retificações', 'ifrs-portal-plugin-editais' ),
                'desc'             => __( 'Envio das retificações ao Edital', 'ifrs-portal-plugin-editais' ),
                'type'             => 'file_advanced',
            ),
            array(
                'id'               => 'edital_anexos_files',
                'name'             => __( 'Anexos', 'ifrs-portal-plugin-editais' ),
                'desc'             => __( 'Envio dos Anexos do Edital', 'ifrs-portal-plugin-editais' ),
                'type'             => 'file_advanced',
            ),
            array(
                'id'               => 'edital_publica_files',
                'name'             => __( 'Demais Publicações', 'ifrs-portal-plugin-editais' ),
                'desc'             => __( 'Envio dos demais arquivos publicados em função do Edital (homologações, resultados e etc.)', 'ifrs-portal-plugin-editais' ),
                'type'             => 'file_advanced',
            ),
        ),
    );

    $meta_boxes[] = array(
        'title'      => __( 'Categorias do Edital', 'ifrs-portal-plugin-editais' ),
        'context'    => 'side',
        'priority'   => 'low',
        'post_types' => 'edital',
        'fields'     => array(
            array(
                'id'             => 'edital_category',
                'type'           => 'taxonomy',
                'taxonomy'       => 'edital_category',
                'add_new'        => false,
                'remove_default' => true,
                'field_type'     => 'checkbox_tree',
            )
        )
    );

    $meta_boxes[] = array(
        'title'      => __( 'Status do Edital', 'ifrs-portal-plugin-editais' ),
        'context'    => 'side',
        'priority'   => 'low',
        'post_types' => 'edital',
        'fields'     => array(
            array(
                'id'             => 'edital_status',
                'type'           => 'taxonomy',
                'taxonomy'       => 'edital_status',
                'add_new'        => false,
                'remove_default' => true,
                'field_type'     => 'radio_list',
            )
        )
    );

    return $meta_boxes;
}
add_filter( 'rwmb_meta_boxes', 'editais_meta_boxes' );

/**
 * Templates
 */
add_filter('archive_template', function($template) {
    global $post;

    if ( is_post_type_archive('edital') && empty(locate_template('archive-edital.php', false))) {
        return plugin_dir_path(__FILE__) . 'templates/archive-edital.php';
    }

    return $template;
});

add_filter('single_template', function($template) {
    global $post;

    if ( is_singular('edital') && empty(locate_template('single-edital.php', false))) {
        return plugin_dir_path(__FILE__) . 'templates/single-edital.php';
    }

    return $template;
});

/**
 * Remove botão de mídia
 */
add_filter('wp_editor_settings', function($settings) {
    global $current_screen;
    if ($current_screen->post_type == 'edital') {
        $settings['media_buttons'] = false;
    }
    return $settings;
});
