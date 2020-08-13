<?php
if (is_admin()) {
    $options['intro'] = get_option( 'ifrs_editais_intro' );

    add_action( 'admin_menu', function() {
        add_submenu_page(
            'edit.php?post_type=edital',
            'Configurações de Editais', // page_title
            'Configurações', // menu_title
            'manage_options', // capability
            'edital_settings', // menu_slug
            function() {
    ?>
                <div class="wrap">
                    <h2><?php _e('Configurações de Editais', 'ifrs-portal-plugin-editais'); ?></h2>
                    <p></p>
                    <?php settings_errors(); ?>

                    <form method="POST" action="options.php">
                        <?php
                            settings_fields( 'default' );
                            do_settings_sections( 'ifrs_editais-admin' );
                            submit_button();
                        ?>
                    </form>
                </div>
    <?php
            }
        );
    } );

    add_action( 'admin_init', function() use ($options) {
        register_setting(
            'default', // option_group
            'ifrs_editais_intro', // option_name
            array ( // args
                'type' => 'string',
                'description' => '',
                'sanitize_callback' => function($input) {
                    $allowed_html = wp_kses_allowed_html( 'post' );

                    // Remove '<textarea>' and '<iframe>' tags
                    unset( $allowed_html['textarea'] );
                    unset( $allowed_html['iframe'] );

                    /**
                     * wp_kses_allowed_html return the wrong values for wp_kses,
                     * need to change "true" -> "array()"
                     */
                    array_walk_recursive(
                        $allowed_html,
                        function ( &$value ) {
                            if ( is_bool( $value ) ) {
                                $value = array();
                            }
                        }
                    );

                    // Run sanitization.
                    return wp_kses( $input, $allowed_html );
                },
                'show_in_rest' => true,
                'default' => ''
            )
        );

        add_settings_section(
            'default', // id
            'Geral', // title
            function() {}, // callback
            'ifrs_editais-admin' // page
        );

        add_settings_field(
            'ifrs_editais_intro', // id
            'Texto de Introdução', // title
            function() use ($options) { // callback
                wp_editor(
                    $options['intro'] ? $options['intro'] : '',
                    'ifrs_editais_intro',
                    array('media_buttons' => false, 'textarea_rows' => '15')
                );
            },
            'ifrs_editais-admin', // page
            'default' // section
        );
    } );
}
