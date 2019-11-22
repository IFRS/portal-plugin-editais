<?php
if ( ! function_exists( 'edital_category_taxonomy' ) ) {
    // Register Custom Taxonomy
    function edital_category_taxonomy() {
        $labels = array(
            'name'                       => _x( 'Categorias de Edital', 'Taxonomy General Name', 'ifrs-portal-plugin-editais' ),
            'singular_name'              => _x( 'Categoria de Edital', 'Taxonomy Singular Name', 'ifrs-portal-plugin-editais' ),
            'menu_name'                  => __( 'Categorias', 'ifrs-portal-plugin-editais' ),
            'all_items'                  => __( 'Todas as categorias de Edital', 'ifrs-portal-plugin-editais' ),
            'parent_item'                => __( 'Categoria de Edital pai', 'ifrs-portal-plugin-editais' ),
            'parent_item_colon'          => __( 'Categoria de Edital pai:', 'ifrs-portal-plugin-editais' ),
            'new_item_name'              => __( 'Nova Categoria de Edital', 'ifrs-portal-plugin-editais' ),
            'add_new_item'               => __( 'Adicionar Nova Categoria de Edital', 'ifrs-portal-plugin-editais' ),
            'edit_item'                  => __( 'Editar Categoria de Edital', 'ifrs-portal-plugin-editais' ),
            'update_item'                => __( 'Atualizar Categoria de Edital', 'ifrs-portal-plugin-editais' ),
            'separate_items_with_commas' => __( 'Categorias de Edital separadas por vírgula', 'ifrs-portal-plugin-editais' ),
            'search_items'               => __( 'Buscar Categoria de Edital', 'ifrs-portal-plugin-editais' ),
            'add_or_remove_items'        => __( 'Adicionar ou remover Categoria de Edital', 'ifrs-portal-plugin-editais' ),
            'choose_from_most_used'      => __( 'Escolher pela Categoria de Edital mais usada', 'ifrs-portal-plugin-editais' ),
            'not_found'                  => __( 'Não encontrada', 'ifrs-portal-plugin-editais' ),
        );
        $capabilities = array(
    		'manage_terms'       => 'manage_edital_category',
            'assign_terms'       => 'assign_edital_category',
    		'edit_terms'         => 'edit_edital_category',
    		'delete_terms'       => 'delete_edital_category',
    	);
        $args = array(
            'labels'            => $labels,
            'hierarchical'      => true,
            'public'            => true,
            'show_ui'           => true,
            'show_admin_column' => true,
            'show_in_nav_menus' => true,
            'show_tagcloud'     => false,
            'capabilities'      => $capabilities,
            'rewrite'           => array('slug' => 'editais/categorias', 'hierarchical' => true, 'with_front' => false),
        );
        register_taxonomy( 'edital_category', array( 'edital' ), $args );
    }

    // Hook into the 'init' action
    add_action( 'init', 'edital_category_taxonomy', 0 );
}

/**
 * Template
 */
add_filter('taxonomy_template', function($template) {
    global $post;

    if ( is_tax('edital_category') && empty(locate_template('taxonomy-edital_category.php', false))) {
        return plugin_dir_path(__FILE__) . 'templates/taxonomy-edital_category.php';
    }

    return $template;
});
