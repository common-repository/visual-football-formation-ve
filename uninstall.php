<?php

//Exit if this file is called outside wordpress
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) { die(); }

require_once( plugin_dir_path( __FILE__ ) . 'shared/class-daextvffve-shared.php' );
require_once( plugin_dir_path( __FILE__ ) . 'admin/class-daextvffve-admin.php' );

//delete options
Daextvffve_Admin::un_delete_options();

//delete database tables
Daextvffve_Admin::un_delete_database_tables();

