<?php
defined('ABSPATH') or die('No script kiddies please!');
/*
Plugin Name: IFRS Portal Editais
Plugin URI:  https://github.com/IFRS/portal-plugin-editais
Description: Plugin para gerenciar Editais.
Version:     1.2.1
Author:      Ricardo Moro
Author URI:  https://github.com/ricardomoro
License:     GPL3
License URI: https://www.gnu.org/licenses/gpl-3.0.txt
Text Domain: ifrs-portal-plugin-editais
Domain Path: /lang
*/

require_once('taxonomy-single-term/class.taxonomy-single-term.php');
require_once('edital-category.php');
require_once('edital-status.php');
require_once('edital.php');
require_once('roles.php');

register_activation_hook(__FILE__, function () {
    flush_rewrite_rules();
    ifrs_portal_editais_addRoles();
});

register_deactivation_hook(__FILE__, function () {
    flush_rewrite_rules();
    ifrs_portal_editais_removeRoles();
});
