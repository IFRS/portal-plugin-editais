<?php
// Fix Media Permissions
add_action('init', function() {
    global $wp_post_types;
    $wp_post_types['attachment']->cap->edit_posts = 'edit_files';
    $wp_post_types['attachment']->cap->delete_posts = 'delete_files';
});

function ifrs_portal_editais_addRoles() {
    $admin = get_role('administrator');
    $admin->add_cap('create_editais');
    $admin->add_cap('publish_editais');
    $admin->add_cap('edit_editais');
    $admin->add_cap('delete_editais');
    $admin->add_cap('assign_edital_category');
    $admin->add_cap('assign_edital_status');

    if (!get_role('cadastrador_editais')) {
        add_role('cadastrador_editais', __('Cadastrador de Editais'), array(
            'read'                   => true,
            'upload_files'           => true,
            'edit_files'             => true,
            'delete_files'           => false,

            'create_editais'         => true,
            'publish_editais'        => true,
            'edit_editais'           => true,
            'delete_editais'         => false,

            'assign_edital_category' => true,
            'assign_edital_status'   => true
        ));
    }

    if (!get_role('gerente_editais')) {
        add_role('gerente_editais', __('Gerente de Editais'), array(
            'read'                   => true,
            'upload_files'           => true,
            'edit_files'             => true,
            'delete_files'           => true,

            'create_editais'         => true,
            'publish_editais'        => true,
            'edit_editais'           => true,
            'delete_editais'         => true,

            'assign_edital_category' => true,
            'assign_edital_status'   => true
        ));
    }
}

function ifrs_portal_editais_removeRoles() {
    $admin = get_role('administrator');
    $admin->remove_cap('create_editais');
    $admin->remove_cap('publish_editais');
    $admin->remove_cap('edit_editais');
    $admin->remove_cap('delete_editais');
    $admin->remove_cap('assign_edital_category');
    $admin->remove_cap('assign_edital_status');

    if (get_role('cadastrador_editais')) {
        remove_role('cadastrador_editais');
    }
    if (get_role('gerente_editais')) {
        remove_role('gerente_editais');
    }
}
