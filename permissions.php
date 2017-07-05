<?php
add_action('init', function() {
    if (get_role( 'cadastrador_editais' )) {
        remove_role( 'cadastrador_editais' );
    }
    add_role('cadastrador_editais', __('Cadastrador de Editais'), array(
        'read'                   => true,
        'upload_files'           => true,
        'manage_files'           => true,

        'create_editais'         => true,
        'edit_editais'           => true,
        'manage_editais'         => false,

        'assign_edital_category' => true
    ));
});
