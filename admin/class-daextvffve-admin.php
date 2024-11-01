<?php

/*
 * this class should be used to work with the administrative side of wordpress
 */
class Daextvffve_Admin{
    
    protected static $instance = null;
    private $shared = null;
    private $screen_id_formations = null;
    private $screen_id_layouts = null;
	private $screen_id_help = null;
	private $screen_id_soccer_engine = null;
    private $screen_id_options = null;

	private $menu_options = null;
    
    private function __construct() {

        //assign an instance of the plugin info
        $this->shared = Daextvffve_Shared::get_instance();
        
        //Load admin style sheet and JavaScript.
        add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_styles' ) );
        add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_scripts' ) );

        //Load the options API registrations and callbacks
        add_action('admin_init', array( $this, 'op_register_options' ));
        
        //Add the admin menu
        add_action( 'admin_menu', array( $this, 'me_add_menu' ) );

	    //Require and instantiate the class used to register the menu options
	    require_once( $this->shared->get( 'dir' ) . 'admin/inc/class-daextvffve-menu-options.php' );
	    $this->menu_options = new Daextvffve_Menu_Options( $this->shared );

    }
    
    /*
     * return an istance of this class
     */
    public static function get_instance() {

        if ( null == self::$instance ) {
            self::$instance = new self;
        }

        return self::$instance;
            
    }
    
    /*
     * enqueue admin-specific style sheet
     */
    public function enqueue_admin_styles() {

        $screen = get_current_screen();

	    //menu formations
	    if ($screen->id == $this->screen_id_formations) {

		    //Select2
		    wp_enqueue_style( $this->shared->get( 'slug' ) . '-select2',
			    $this->shared->get( 'url' ) . 'admin/assets/inc/select2/dist/css/select2.min.css', array(),
			    $this->shared->get( 'ver' ) );
		    wp_enqueue_style( $this->shared->get( 'slug' ) . '-select2-custom',
			    $this->shared->get( 'url' ) . 'admin/assets/css/select2-custom.css', array(),
			    $this->shared->get( 'ver' ) );
	    	
		    //jQuery UI Dialog
		    wp_enqueue_style($this->shared->get('slug') . '-jquery-ui-dialog',
			    $this->shared->get('url') . 'admin/assets/css/jquery-ui-dialog.css', array(),
			    $this->shared->get('ver'));
		    wp_enqueue_style($this->shared->get('slug') . '-jquery-ui-dialog-custom',
			    $this->shared->get('url') . 'admin/assets/css/jquery-ui-dialog-custom.css', array(),
			    $this->shared->get('ver'));

            wp_enqueue_style($this->shared->get('slug') . '-jquery-ui-tooltip-custom', $this->shared->get('url') . 'admin/assets/css/jquery-ui-tooltip-custom.css', array(), $this->shared->get('ver'));
            wp_enqueue_style($this->shared->get('slug') . '-framework-menu', $this->shared->get('url') . 'admin/assets/css/framework/menu.css', array(), $this->shared->get('ver'));
		    wp_enqueue_style( $this->shared->get('slug') .'-menu-formations', $this->shared->get('url') . 'admin/assets/css/menu-formations.css', array(), $this->shared->get('ver') );

	    }
        
        if ( $screen->id == $this->screen_id_layouts ) {

            //if is set load a google font
            if( strlen( trim( get_option( $this->shared->get("slug") . "_load_google_font" ) ) )  > 0 ){

                wp_enqueue_style( $this->shared->get( 'slug' ) . '-google-font',
                    esc_url( get_option( $this->shared->get( 'slug' ) . '_load_google_font' ) ), false );

            }

	        //Select2
	        wp_enqueue_style( $this->shared->get( 'slug' ) . '-select2',
		        $this->shared->get( 'url' ) . 'admin/assets/inc/select2/dist/css/select2.min.css', array(),
		        $this->shared->get( 'ver' ) );
	        wp_enqueue_style( $this->shared->get( 'slug' ) . '-select2-custom',
		        $this->shared->get( 'url' ) . 'admin/assets/css/select2-custom.css', array(),
		        $this->shared->get( 'ver' ) );
        	
	        //jQuery UI Dialog
	        wp_enqueue_style($this->shared->get('slug') . '-jquery-ui-dialog',
		        $this->shared->get('url') . 'admin/assets/css/jquery-ui-dialog.css', array(),
		        $this->shared->get('ver'));
	        wp_enqueue_style($this->shared->get('slug') . '-jquery-ui-dialog-custom',
		        $this->shared->get('url') . 'admin/assets/css/jquery-ui-dialog-custom.css', array(),
		        $this->shared->get('ver'));

            wp_enqueue_style($this->shared->get('slug') . '-jquery-ui-tooltip-custom', $this->shared->get('url') . 'admin/assets/css/jquery-ui-tooltip-custom.css', array(), $this->shared->get('ver'));
            wp_enqueue_style($this->shared->get('slug') . '-framework-menu', $this->shared->get('url') . 'admin/assets/css/framework/menu.css', array(), $this->shared->get('ver'));
	        wp_enqueue_style( $this->shared->get('slug') .'-menu-layouts', $this->shared->get('url') . 'admin/assets/css/menu-layouts.css', array(), $this->shared->get('ver') );
            wp_enqueue_style( $this->shared->get('slug') .'-draggable-positions', $this->shared->get('url') . 'admin/assets/css/draggable-positions.css', array(), $this->shared->get('ver') );

        }

	    //Menu Help
	    if ($screen->id == $this->screen_id_help) {

		    wp_enqueue_style($this->shared->get('slug') . '-menu-help',
			    $this->shared->get('url') . 'admin/assets/css/menu-help.css', array(), $this->shared->get('ver'));

	    }

        //Menu Soccer Engine
        if ($screen->id == $this->screen_id_soccer_engine) {

            wp_enqueue_style($this->shared->get('slug') . '-menu-soccer-engine',
                $this->shared->get('url') . 'admin/assets/css/menu-soccer-engine.css', array(), $this->shared->get('ver'));

        }

	    if ( $screen->id == $this->screen_id_options ) {

		    //Select2
		    wp_enqueue_style( $this->shared->get( 'slug' ) . '-select2',
			    $this->shared->get( 'url' ) . 'admin/assets/inc/select2/dist/css/select2.min.css', array(),
			    $this->shared->get( 'ver' ) );
		    wp_enqueue_style( $this->shared->get( 'slug' ) . '-select2-custom',
			    $this->shared->get( 'url' ) . 'admin/assets/css/select2-custom.css', array(),
			    $this->shared->get( 'ver' ) );

		    wp_enqueue_style('wp-color-picker');

            wp_enqueue_style($this->shared->get('slug') . '-framework-options', $this->shared->get('url') . 'admin/assets/css/framework/options.css', array(), $this->shared->get('ver'));
		    wp_enqueue_style($this->shared->get('slug') . '-jquery-ui-tooltip-custom', $this->shared->get('url') . 'admin/assets/css/jquery-ui-tooltip-custom.css', array(), $this->shared->get('ver'));

	    }

    }
    
    /*
     * enqueue admin-specific javascript
     */
    public function enqueue_admin_scripts() {

        //Store the JavaScript parameters in the window.DAEXTVFFVE_PARAMETERS object
        $php_data = 'window.DAEXTVFFVE_PARAMETERS = {';
        $php_data .= 'admin_url: "' . get_admin_url() . '"';
        $php_data .= '};';

	    $wp_localize_script_data = array(
		    'deleteText' => esc_html__( 'Delete', 'visual-football-formation-ve'),
		    'cancelText' => esc_html__( 'Cancel', 'visual-football-formation-ve'),
	    );
    	
        $screen = get_current_screen();

	    //menu formations
	    if ( $screen->id == $this->screen_id_formations ) {

	        //Media Uploader
            wp_enqueue_media();
            wp_enqueue_script( $this->shared->get('slug') . '-media-uploader', $this->shared->get('url') . 'admin/assets/js/media-uploader.js', array('jquery'), $this->shared->get('ver') );

	        //JQuery UI Tooltips
            wp_enqueue_script('jquery-ui-tooltip');
            wp_enqueue_script($this->shared->get('slug') . '-jquery-ui-tooltip-init', $this->shared->get('url') . 'admin/assets/js/jquery-ui-tooltip-init.js', array('jquery'), $this->shared->get('ver'));

            //Select2
		    wp_enqueue_script( $this->shared->get( 'slug' ) . '-select2',
			    $this->shared->get( 'url' ) . 'admin/assets/inc/select2/dist/js/select2.min.js', array('jquery'),
			    $this->shared->get( 'ver' ) );

		    //Formations Menu
		    wp_enqueue_script( $this->shared->get( 'slug' ) . '-menu-formations',
			    $this->shared->get( 'url' ) . 'admin/assets/js/menu-formations.js',
			    array( 'jquery', 'jquery-ui-dialog', 'daextvffve-select2' ),
			    $this->shared->get( 'ver' ) );

		    wp_localize_script( $this->shared->get( 'slug' ) . '-menu-formations', 'objectL10n',
			    $wp_localize_script_data );

            wp_add_inline_script( $this->shared->get('slug') . '-menu-formations', $php_data, 'before' );

        }
        
        //menu layouts
        if ( $screen->id == $this->screen_id_layouts ) {

            //JQuery UI Tooltips
            wp_enqueue_script('jquery-ui-tooltip');
            wp_enqueue_script($this->shared->get('slug') . '-jquery-ui-tooltip-init', $this->shared->get('url') . 'admin/assets/js/jquery-ui-tooltip-init.js', array('jquery'), $this->shared->get('ver'));

	        //Select2
	        wp_enqueue_script( $this->shared->get( 'slug' ) . '-select2',
		        $this->shared->get( 'url' ) . 'admin/assets/inc/select2/dist/js/select2.min.js', array('jquery'),
		        $this->shared->get( 'ver' ) );

	        //Layouts Menu
	        wp_enqueue_script( $this->shared->get( 'slug' ) . '-menu-layouts',
		        $this->shared->get( 'url' ) . 'admin/assets/js/menu-layouts.js',
		        array( 'jquery', 'jquery-ui-dialog', 'daextvffve-select2' ),
		        $this->shared->get( 'ver' ) );
	        wp_localize_script( $this->shared->get( 'slug' ) . '-menu-layouts', 'objectL10n',
		        $wp_localize_script_data );
        	
            wp_enqueue_script( $this->shared->get('slug') . '-draggable-positions', $this->shared->get('url') . 'admin/assets/js/draggable-positions.js', array( 'jquery', 'jquery-ui-draggable' ), $this->shared->get('ver') );

            wp_add_inline_script( $this->shared->get('slug') . '-menu-layouts', $php_data, 'before' );

        }
        
        //menu options
        if ( $screen->id == $this->screen_id_options ) {

            //JQuery UI Tooltips
            wp_enqueue_script('jquery-ui-tooltip');
            wp_enqueue_script($this->shared->get('slug') . '-jquery-ui-tooltip-init', $this->shared->get('url') . 'admin/assets/js/jquery-ui-tooltip-init.js', array('jquery'), $this->shared->get('ver'));

	        //Select2
	        wp_enqueue_script( $this->shared->get( 'slug' ) . '-select2',
		        $this->shared->get( 'url' ) . 'admin/assets/inc/select2/dist/js/select2.min.js', array('jquery'),
		        $this->shared->get( 'ver' ) );

	        //Color Picker Initialization
	        wp_enqueue_script( $this->shared->get( 'slug' ) . '-wp-color-picker-init',
		        $this->shared->get( 'url' ) . 'admin/assets/js/wp-color-picker-init.js',
		        array( 'jquery', 'wp-color-picker' ), false, true );

            //Color Picker Initialization
            wp_enqueue_script( $this->shared->get( 'slug' ) . '-menu-options',
                $this->shared->get( 'url' ) . 'admin/assets/js/menu-options.js',
                array( 'jquery' ), false, true );

        }

    }
    
    /*
     * register the admin menu
     */
    public function me_add_menu() {

	    //The icon in Base64 format
	    $icon_base64 = 'PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0idXRmLTgiPz4NCjwhLS0gR2VuZXJhdG9yOiBBZG9iZSBJbGx1c3RyYXRvciAyNS4yLjMsIFNWRyBFeHBvcnQgUGx1Zy1JbiAuIFNWRyBWZXJzaW9uOiA2LjAwIEJ1aWxkIDApICAtLT4NCjxzdmcgdmVyc2lvbj0iMS4xIiBpZD0iTGF5ZXJfMSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB4bWxuczp4bGluaz0iaHR0cDovL3d3dy53My5vcmcvMTk5OS94bGluayIgeD0iMHB4IiB5PSIwcHgiDQoJIHZpZXdCb3g9IjAgMCAyMCAyMCIgc3R5bGU9ImVuYWJsZS1iYWNrZ3JvdW5kOm5ldyAwIDAgMjAgMjA7IiB4bWw6c3BhY2U9InByZXNlcnZlIj4NCjxwYXRoIGQ9Ik02LjgsOS4xTDEwLDYuOGwzLjIsMi4zTDEyLDEyLjlIOEw2LjgsOS4xeiBNMTAsMGMxLjQsMCwyLjcsMC4zLDMuOSwwLjhzMi4zLDEuMiwzLjIsMi4xYzAuOSwwLjksMS42LDEuOSwyLjEsMy4yDQoJUzIwLDguNywyMCwxMHMtMC4yLDIuNi0wLjgsMy45Yy0wLjYsMS4zLTEuMywyLjMtMi4xLDMuMmMtMC45LDAuOS0xLjksMS42LTMuMiwyLjFTMTEuMywyMCwxMCwyMHMtMi42LTAuMy0zLjktMC44UzMuOCwxOCwyLjksMTcuMQ0KCXMtMS42LTEuOS0yLjEtMy4yUzAsMTEuMywwLDEwczAuMy0yLjYsMC44LTMuOVMyLDMuOCwyLjksMi45czItMS42LDMuMi0yLjFTOC42LDAsMTAsMHogTTE2LjksMTUuMWMxLjEtMS41LDEuNy0zLjIsMS43LTUuMWwwLDANCglsLTEuMSwxbC0yLjctMi41bDAuNy0zLjZMMTcsNWMtMS4xLTEuNS0yLjYtMi42LTQuMy0zLjFsMC42LDEuNEwxMCw1TDYuOCwzLjJsMC42LTEuNEM1LjYsMi40LDQuMiwzLjQsMyw1bDEuNS0wLjFsMC43LDMuNkwyLjYsMTENCglsLTEuMS0xbDAsMGMwLDEuOSwwLjYsMy42LDEuNyw1LjFsMC4zLTEuNUw3LjEsMTRsMS42LDMuM2wtMS4zLDAuOGMwLjksMC4zLDEuOCwwLjQsMi43LDAuNHMxLjgtMC4xLDIuNy0wLjRsLTEuMy0wLjhsMS42LTMuMw0KCWwzLjYtMC40TDE2LjksMTUuMXoiLz4NCjwvc3ZnPg0K';

	    //The icon in the data URI scheme
	    $icon_data_uri = 'data:image/svg+xml;base64,' . $icon_base64;

        add_menu_page(
	        esc_html__('VFFVE', 'visual-football-formation-ve'),
	        esc_html__('VFFVE', 'visual-football-formation-ve'),
            'edit_posts',
            $this->shared->get('slug') . '-formations',
            array( $this, 'me_display_menu_formations'),
	        $icon_data_uri
        );
        
        $this->screen_id_formations = add_submenu_page(
            $this->shared->get('slug') . '-formations',
	        esc_html__('VFFVE - Formations', 'visual-football-formation-ve'),
		    esc_html__('Formations', 'visual-football-formation-ve'),
            'edit_posts',
            $this->shared->get('slug') . '-formations',
            array( $this, 'me_display_menu_formations')
        );
        
        $this->screen_id_layouts = add_submenu_page(
            $this->shared->get('slug') . '-formations',
	        esc_html__('VFFVE - Layouts', 'visual-football-formation-ve'),
		    esc_html__('Layouts', 'visual-football-formation-ve'),
            'edit_posts',
            $this->shared->get('slug') . '-layouts',
            array( $this, 'me_display_menu_layouts')
        );

	    $this->screen_id_help = add_submenu_page(
		    $this->shared->get( 'slug' ) . '-formations',
		    esc_html__( 'VFFVE - Help', 'visual-football-formation-ve'),
		    esc_html__( 'Help', 'visual-football-formation-ve'),
		    'manage_options',
		    $this->shared->get( 'slug' ) . '-help',
		    array( $this, 'me_display_menu_help' )
	    );

        $this->screen_id_soccer_engine = add_submenu_page(
            $this->shared->get( 'slug' ) . '-formations',
            esc_html__( 'VFFVE - Soccer Engine', 'visual-football-formation-ve'),
            esc_html__( 'Soccer Engine', 'visual-football-formation-ve'),
            'manage_options',
            $this->shared->get( 'slug' ) . '-soccer-engine',
            array( $this, 'me_display_menu_soccer_engine' )
        );
        
        $this->screen_id_options = add_submenu_page(
            $this->shared->get('slug') . '-formations',
	        esc_html__('VFFVE - Options', 'visual-football-formation-ve'),
		    esc_html__('Options', 'visual-football-formation-ve'),
            'manage_options',
            $this->shared->get('slug') . '-options',
            array( $this, 'me_display_menu_options')
        );

    }

    /*
     * includes the formations view
     */
    public function me_display_menu_formations() {
        include_once( 'view/formations.php' );
    }
    
    /*
     * includes the layouts view
     */
    public function me_display_menu_layouts() {
        include_once( 'view/layouts.php' );
    }

	/*
	 * includes the help view
	 */
	public function me_display_menu_help() {
		include_once( 'view/help.php' );
	}

    /*
     * includes the soccer engine view
     */
    public function me_display_menu_soccer_engine() {
        include_once( 'view/soccer-engine.php' );
    }

    /*
     * includes the options view
     */
    public function me_display_menu_options() {
        include_once( 'view/options.php' );
    }
    
    /*
     * get the layout description
     * 
     * @since 1.00
     * 
     * @param int $layout_id the layout id
     * @return string the layout description
     */
    private function ut_get_layout_name($layout_id){
        
        global $wpdb;
        $table_name = $wpdb->prefix . $this->shared->get('slug') . "_layout";
        $safe_sql = $wpdb->prepare("SELECT description FROM $table_name WHERE layout_id = %d", $layout_id);
        $layout_obj = $wpdb->get_row($safe_sql);
        
        return $layout_obj->description;
        
    }
    
    /**
     * check if the layout is used by a formation
     * 
     * @param int $layout_id the layout id
     * @return bool true if the layout is used, false if the layout is not uysed
     */
    private function ut_layout_is_used($layout_id){

	    global $wpdb; $table_name = $wpdb->prefix . $this->shared->get('slug') . "_formation";
	    $safe_sql = $wpdb->prepare("SELECT COUNT(*) FROM $table_name WHERE layout_id = %d ", $layout_id);
	    $number_of_records = $wpdb->get_var($safe_sql);

	    if( $number_of_records > 0 ){
		    return true;
	    }else{
		    return false;
	    }

    }
    
    /*
     * plugin activation
     */
    static public function ac_activate(){
        
        self::ac_initialize_options();
        self::ac_create_database_tables();
        
    }
    
    /*
     * initialize plugin options
     */
    static private function ac_initialize_options(){

	    //assign an instance of Daextvffve_Shared
	    $shared = Daextvffve_Shared::get_instance();

	    foreach ( $shared->get( 'options' ) as $key => $value ) {
		    add_option( $key, $value );
	    }
        
    }  
        
    /*
     * create the plugin database tables
     */
    static private function ac_create_database_tables(){

        //check database version and create the database
        if( intval(get_option('daextvffve_database_version')) < 1 ){

            require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

            //create *prefix*_daextvffve_formation
            global $wpdb;$table_name=$wpdb->prefix . "daextvffve_formation";
            $sql = "CREATE TABLE $table_name (
		  		formation_id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
	            description TEXT DEFAULT '' NOT NULL,
                  layout_id BIGINT UNSIGNED NOT NULL,
                  player_name_1 TEXT DEFAULT '' NOT NULL,
                  player_image_1 TEXT DEFAULT '' NOT NULL,
                  player_name_2 TEXT DEFAULT '' NOT NULL,
                  player_image_2 TEXT DEFAULT '' NOT NULL,
                  player_name_3 TEXT DEFAULT '' NOT NULL,
                  player_image_3 TEXT DEFAULT '' NOT NULL,
                  player_name_4 TEXT DEFAULT '' NOT NULL,
                  player_image_4 TEXT DEFAULT '' NOT NULL,
                  player_name_5 TEXT DEFAULT '' NOT NULL,
                  player_image_5 TEXT DEFAULT '' NOT NULL,
                  player_name_6 TEXT DEFAULT '' NOT NULL,
                  player_image_6 TEXT DEFAULT '' NOT NULL,
                  player_name_7 TEXT DEFAULT '' NOT NULL,
                  player_image_7 TEXT DEFAULT '' NOT NULL,
                  player_name_8 TEXT DEFAULT '' NOT NULL,
                  player_image_8 TEXT DEFAULT '' NOT NULL,
                  player_name_9 TEXT DEFAULT '' NOT NULL,
                  player_image_9 TEXT DEFAULT '' NOT NULL,
                  player_name_10 TEXT DEFAULT '' NOT NULL,
                  player_image_10 TEXT DEFAULT '' NOT NULL,
                  player_name_11 TEXT DEFAULT '' NOT NULL,
                  player_image_11 TEXT DEFAULT '' NOT NULL
		)
		COLLATE = utf8_general_ci
		";

            dbDelta($sql);

            //create *prefix*_daextvffve_layout
            global $wpdb;$table_name=$wpdb->prefix . "daextvffve_layout";
            $sql = "CREATE TABLE $table_name (
		  layout_id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
		  description TEXT DEFAULT '' NOT NULL,
                  player_x_1 INT UNSIGNED DEFAULT 0 NOT NULL,
                  player_y_1 INT UNSIGNED DEFAULT 0 NOT NULL,
                  player_x_2 INT UNSIGNED DEFAULT 0 NOT NULL,
                  player_y_2 INT UNSIGNED DEFAULT 0 NOT NULL,
                  player_x_3 INT UNSIGNED DEFAULT 0 NOT NULL,
                  player_y_3 INT UNSIGNED DEFAULT 0 NOT NULL,
                  player_x_4 INT UNSIGNED DEFAULT 0 NOT NULL,
                  player_y_4 INT UNSIGNED DEFAULT 0 NOT NULL,
                  player_x_5 INT UNSIGNED DEFAULT 0 NOT NULL,
                  player_y_5 INT UNSIGNED DEFAULT 0 NOT NULL,
                  player_x_6 INT UNSIGNED DEFAULT 0 NOT NULL,
                  player_y_6 INT UNSIGNED DEFAULT 0 NOT NULL,
                  player_x_7 INT UNSIGNED DEFAULT 0 NOT NULL,
                  player_y_7 INT UNSIGNED DEFAULT 0 NOT NULL,
                  player_x_8 INT UNSIGNED DEFAULT 0 NOT NULL,
                  player_y_8 INT UNSIGNED DEFAULT 0 NOT NULL,
                  player_x_9 INT UNSIGNED DEFAULT 0 NOT NULL,
                  player_y_9 INT UNSIGNED DEFAULT 0 NOT NULL,
                  player_x_10 INT UNSIGNED DEFAULT 0 NOT NULL,
                  player_y_10 INT UNSIGNED DEFAULT 0 NOT NULL,
                  player_x_11 INT UNSIGNED DEFAULT 0 NOT NULL,
                  player_y_11 INT UNSIGNED DEFAULT 0 NOT NULL,
                  player_show_1 TINYINT(1) UNSIGNED DEFAULT 0 NOT NULL,
                  player_show_2 TINYINT(1) UNSIGNED DEFAULT 0 NOT NULL,
                  player_show_3 TINYINT(1) UNSIGNED DEFAULT 0 NOT NULL,
                  player_show_4 TINYINT(1) UNSIGNED DEFAULT 0 NOT NULL,
                  player_show_5 TINYINT(1) UNSIGNED DEFAULT 0 NOT NULL,
                  player_show_6 TINYINT(1) UNSIGNED DEFAULT 0 NOT NULL,
                  player_show_7 TINYINT(1) UNSIGNED DEFAULT 0 NOT NULL,
                  player_show_8 TINYINT(1) UNSIGNED DEFAULT 0 NOT NULL,
                  player_show_9 TINYINT(1) UNSIGNED DEFAULT 0 NOT NULL,
                  player_show_10 TINYINT(1) UNSIGNED DEFAULT 0 NOT NULL,
                  player_show_11 TINYINT(1) UNSIGNED DEFAULT 0 NOT NULL
		)
		COLLATE = utf8_general_ci
		";

            dbDelta($sql);

            //set default layouts
            $wpdb->query("INSERT INTO $table_name (description, player_x_1, player_y_1, player_x_2, player_y_2, player_x_3, player_y_3, player_x_4, player_y_4, player_x_5, player_y_5, player_x_6, player_y_6, player_x_7, player_y_7, player_x_8, player_y_8, player_x_9, player_y_9, player_x_10, player_y_10, player_x_11, player_y_11, player_show_1, player_show_2, player_show_3, player_show_4, player_show_5, player_show_6, player_show_7, player_show_8, player_show_9, player_show_10, player_show_11) VALUES " .
                "('4-4-2', 201, 370, 56, 245, 159, 274, 245, 274, 346, 245, 56, 124, 159, 157, 245, 157, 346, 124, 159, 45, 245, 45, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1)," .
                "('5-3-2', 201, 370, 56, 237, 124, 275, 201, 275, 278, 275, 346, 237, 124, 136, 201, 177, 278, 136, 158, 45, 243, 45, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1)," .
                "('4-4-1-1', 201, 370, 56, 263, 159, 289, 245, 289, 346, 263, 56, 173, 159, 199, 245, 199, 346, 173, 201, 123, 201, 41, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1)," .
                "('4-4-2 Diamond', 201, 370, 56, 245, 136, 289, 264, 289, 346, 245, 101, 157, 201, 225, 301, 157, 201, 119, 136, 40, 264, 41, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1)," .
                "('4-3-3', 201, 370, 56, 245, 159, 274, 245, 274, 346, 245, 94, 148, 201, 190, 307, 148, 94, 60, 201, 40, 307, 61, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1)," .
                "('4-5-1', 201, 370, 56, 245, 159, 274, 245, 274, 346, 245, 56, 89, 122, 147, 201, 187, 280, 147, 346, 89, 201, 41, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1)," .
                "('4-2-3-1', 201, 370, 56, 245, 157, 283, 245, 283, 346, 245, 157, 199, 245, 199, 86, 84, 201, 122, 315, 84, 201, 41, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1)," .
                "('3-4-3', 201, 370, 94, 285, 201, 285, 306, 285, 67, 145, 150, 197, 252, 197, 333, 145, 94, 63, 201, 40, 306, 63, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1)," .
                "('3-5-2', 201, 370, 111, 281, 201, 281, 291, 281, 58, 187, 130, 131, 201, 187, 270, 131, 343, 187, 152, 40, 249, 41, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1)");

            //Update database version
            update_option('daextvffve_database_version',"1");

        }

    }
    
    /*
     * delete plugin options
     */
    static public function un_delete_options(){

	    //assign an instance of Daextvffve_Shared
	    $shared = Daextvffve_Shared::get_instance();

	    foreach ( $shared->get( 'options' ) as $key => $value ) {
		    delete_option( $key );
	    }
        
    }
    
    /*
     * delete plugin database
     */
    static public function un_delete_database_tables(){
        
        //assign an instance of the plugin info
        $shared = Daextvffve_Shared::get_instance();
        
        global $wpdb;

        $table_name = $wpdb->prefix . $shared->get('slug') . "_formation";
        $sql = "DROP TABLE $table_name";  
        $wpdb->query($sql);

        $table_name = $wpdb->prefix . $shared->get('slug') . "_layout";
        $sql = "DROP TABLE $table_name";  
        $wpdb->query($sql);
        
    }

	/*
	 * register options
	 */
	public function op_register_options() {

		$this->menu_options->register_options();

	}


	/**
	 * Echo all the dismissible notices based on the values of the $notices array.
	 *
	 * @param $notices
	 */
	public function dismissible_notice($notices){

		foreach($notices as $key => $notice){
			echo '<div class="' . esc_attr($notice['class']) . ' settings-error notice is-dismissible below-h2"><p>' . esc_html($notice['message']) . '</p></div>';
		}

	}
    
}