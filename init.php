<?php
/*
Plugin Name: Visual Football Formation VE
Description: Create football formations inside your posts.
Version: 1.07
Author: DAEXT
Author URI: https://daext.com
Text Domain: visual-football-formation-ve
*/

//Prevent direct access to this file
if ( ! defined( 'WPINC' ) ) { die(); }

//Class shared across public and admin
require_once( plugin_dir_path( __FILE__ ) . 'shared/class-daextvffve-shared.php' );

//Public
require_once( plugin_dir_path( __FILE__ ) . 'public/class-daextvffve-public.php' );
add_action( 'plugins_loaded', array( 'Daextvffve_Public', 'get_instance' ) );

//Admin
if ( is_admin() ) {

	require_once( plugin_dir_path( __FILE__ ) . 'admin/class-daextvffve-admin.php' );

	// If this is not an AJAX request, create a new singleton instance of the admin class.
	if(! defined( 'DOING_AJAX' ) || ! DOING_AJAX ){
		add_action( 'plugins_loaded', array( 'Daextvffve_Admin', 'get_instance' ) );
	}

	// Activate the plugin using only the class static methods.
	register_activation_hook( __FILE__, array( 'Daextvffve_Admin', 'ac_activate' ) );

}

//Customize the action links in the "Plugins" menu
function daextvffve_customize_action_links( $actions ) {
    $actions[] = '<a href="https://daext.com/soccer-engine/">' . esc_html__('Buy Soccer Engine', 'visual-football-formation-ve') . '</a>';
    return $actions;
}
add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), 'daextvffve_customize_action_links' );