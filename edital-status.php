<?php
if ( ! function_exists( 'edital_status_taxonomy' ) ) {
    // Register Custom Taxonomy
    function edital_status_taxonomy() {
        $labels = array(
            'name'                       => _x( 'Status de Edital', 'Taxonomy General Name', 'ifrs-portal-plugin-editais' ),
            'singular_name'              => _x( 'Status de Edital', 'Taxonomy Singular Name', 'ifrs-portal-plugin-editais' ),
            'menu_name'                  => __( 'Status', 'ifrs-portal-plugin-editais' ),
            'all_items'                  => __( 'Todos os Status de Edital', 'ifrs-portal-plugin-editais' ),
            'parent_item'                => __( 'Status de Edital pai', 'ifrs-portal-plugin-editais' ),
            'parent_item_colon'          => __( 'Status de Edital pai:', 'ifrs-portal-plugin-editais' ),
            'new_item_name'              => __( 'Novo Status de Edital', 'ifrs-portal-plugin-editais' ),
            'add_new_item'               => __( 'Adicionar Novo Status de Edital', 'ifrs-portal-plugin-editais' ),
            'edit_item'                  => __( 'Editar Status de Edital', 'ifrs-portal-plugin-editais' ),
            'update_item'                => __( 'Atualizar Status de Edital', 'ifrs-portal-plugin-editais' ),
            'separate_items_with_commas' => __( 'Status de Edital separados por vírgula', 'ifrs-portal-plugin-editais' ),
            'search_items'               => __( 'Buscar Status de Edital', 'ifrs-portal-plugin-editais' ),
            'add_or_remove_items'        => __( 'Adicionar ou remover Status de Edital', 'ifrs-portal-plugin-editais' ),
            'choose_from_most_used'      => __( 'Escolher pelo Status de Edital mais usado', 'ifrs-portal-plugin-editais' ),
            'not_found'                  => __( 'Não encontrado', 'ifrs-portal-plugin-editais' ),
        );
        $capabilities = array(
    		'manage_terms'       => 'manage_edital_status',
            'assign_terms'       => 'assign_edital_status',
    		'edit_terms'         => 'edit_edital_status',
    		'delete_terms'       => 'delete_edital_status',
    	);
        $args = array(
            'labels'            => $labels,
            'hierarchical'      => false,
            'public'            => true,
            'show_ui'           => true,
            'show_admin_column' => true,
            'show_in_nav_menus' => true,
            'show_tagcloud'     => false,
            'capabilities'      => $capabilities,
            'rewrite'           => array('slug' => 'editais/status', 'with_front' => false),
        );
        register_taxonomy( 'edital_status', array( 'edital' ), $args );
    }

    // Hook into the 'init' action
    add_action( 'init', 'edital_status_taxonomy', 0 );
}

/**
 * Template
 */
add_filter('taxonomy_template', function($template) {
    global $post;

    if ( is_tax('edital_status') && empty(locate_template('taxonomy-edital_status.php', false))) {
        return plugin_dir_path(__FILE__) . 'templates/taxonomy-edital_status.php';
    }

    return $template;
});

// Ajusta o título padrão do bloco Query Title para esta taxonomia
add_filter('get_the_archive_title', function($title) {
    if (is_tax('edital_status')) {
        $term = get_queried_object();
        if ($term && ! is_wp_error($term)) {
            $title = sprintf(__('Editais com o status %s', 'ifrs-portal-plugin-editais'), $term->name);
        }
    }

    return $title;
});
