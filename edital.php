<?php
if ( ! function_exists('edital_post_type') ) {
    function edital_post_type() {
        $labels = array(
            'name'               => _x( 'Editais', 'Post Type General Name', 'ifrs-portal-common-plugin' ),
            'singular_name'      => _x( 'Edital', 'Post Type Singular Name', 'ifrs-portal-common-plugin' ),
            'menu_name'          => __( 'Editais', 'ifrs-portal-common-plugin' ),
            'name_admin_bar'     => __( 'Editais', 'ifrs-portal-common-plugin' ),
            'parent_item_colon'  => __( 'Edital principal:', 'ifrs-portal-common-plugin' ),
            'all_items'          => __( 'Todos os Editais', 'ifrs-portal-common-plugin' ),
            'add_new_item'       => __( 'Adicionar Novo Edital', 'ifrs-portal-common-plugin' ),
            'add_new'            => __( 'Adicionar Novo', 'ifrs-portal-common-plugin' ),
            'new_item'           => __( 'Novo Edital', 'ifrs-portal-common-plugin' ),
            'edit_item'          => __( 'Editar Edital', 'ifrs-portal-common-plugin' ),
            'update_item'        => __( 'Atualizar Edital', 'ifrs-portal-common-plugin' ),
            'view_item'          => __( 'Ver Edital', 'ifrs-portal-common-plugin' ),
            'search_items'       => __( 'Buscar Edital', 'ifrs-portal-common-plugin' ),
            'not_found'          => __( 'Não encontrado', 'ifrs-portal-common-plugin' ),
            'not_found_in_trash' => __( 'Não encontrado na Lixeira', 'ifrs-portal-common-plugin' ),
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
			'edit_others_posts'      => 'manage_editais',
			'publish_posts'          => 'manage_editais',
			'read_private_posts'     => 'read',

			// primitive caps used inside of map_meta_cap()
			'read'                   => 'read',
			'delete_posts'           => 'manage_editais',
			'delete_private_posts'   => 'manage_editais',
			'delete_published_posts' => 'manage_editais',
			'delete_others_posts'    => 'manage_editais',
			'edit_private_posts'     => 'edit_editais',
			'edit_published_posts'   => 'edit_editais',
		);
        $args = array(
            'label'               => __( 'edital', 'ifrs-portal-common-plugin' ),
            'description'         => __( 'Editais', 'ifrs-portal-common-plugin' ),
            'labels'              => $labels,
            'supports'            => array( 'title', 'revisions' ),
            'taxonomies'          => array('edital_category'),
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
            'capability_type'     => array('edital', 'editais'),
            'map_meta_cap'        => true,
            'capabilities'        => $capabilities,
            'rewrite'             => array('slug' => 'editais'),
        );
        register_post_type( 'edital', $args );
    }

    // Hook into the 'init' action
    add_action( 'init', 'edital_post_type', 1 );
}

// MetaBox
function editais_meta_boxes( $meta_boxes ) {
    $meta_boxes[] = array(
        'title'      => __( 'Dados do Edital', 'ifrs-portal-common-plugin' ),
        'post_types' => 'edital',
        'fields'     => array(
            array(
                'id'             => 'edital_date',
                'name'           => __( 'Data de Publicação', 'ifrs-portal-common-plugin' ),
                'desc'           => __('Selecione a data de publicação oficial do Edital', 'ifrs-portal-common-plugin' ),
                'attributes'     => array(
                    'required'   => true,
                ),
                'type'           => 'date',
                'timestamp'      => true,
                'js_options'     => array(
                    'dateFormat' => 'dd/mm/yy'
                )

            ),
        )
    );
    $meta_boxes[] = array(
        'title'      => __( 'Arquivos Associados', 'ifrs-portal-common-plugin' ),
        'post_types' => 'edital',
        'fields'     => array(
            array(
                'id'               => 'edital_file',
                'name'             => __( 'Edital', 'ifrs-portal-common-plugin' ),
                'desc'             => __('Envio do Edital original', 'ifrs-portal-common-plugin' ),
                'type'             => 'file_advanced',
                'max_file_uploads' => 1,
            ),
            array(
                'id'               => 'edital_retifica_files',
                'name'             => __( 'Retificações', 'ifrs-portal-common-plugin' ),
                'desc'             => __('Envio das retificações ao Edital', 'ifrs-portal-common-plugin' ),
                'type'             => 'file_advanced',
            ),
            array(
                'id'               => 'edital_anexos_files',
                'name'             => __( 'Anexos', 'ifrs-portal-common-plugin' ),
                'desc'             => __('Envio dos Anexos do Edital', 'ifrs-portal-common-plugin' ),
                'type'             => 'file_advanced',
            ),
            array(
                'id'               => 'edital_publica_files',
                'name'             => __( 'Demais Publicações', 'ifrs-portal-common-plugin' ),
                'desc'             => __('Envio dos demais arquivos publicados em função do Edital (homologações, resultados e etc.)', 'ifrs-portal-common-plugin' ),
                'type'             => 'file_advanced',
            ),
        ),
    );

    return $meta_boxes;
}
add_filter( 'rwmb_meta_boxes', 'editais_meta_boxes' );
