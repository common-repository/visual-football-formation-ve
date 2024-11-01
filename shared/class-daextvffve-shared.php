<?php

/*
 * this class should be used to stores value shared by the admin and public side
 * of wordpress
 */
class Daextvffve_Shared{

    protected static $instance = null;
    
    private $data = array();
    
    private function __construct(){

        $this->data['slug'] = 'daextvffve';
        $this->data['ver'] = '1.07';
        $this->data['dir'] = substr(plugin_dir_path(__FILE__), 0, -7);
        $this->data['url'] = substr(plugin_dir_url(__FILE__), 0, -7);

	    //Here are stored the plugin option with the related default values
	    $this->data['options'] = [

            //DATABASE VERSION -------------------------------------------------------------
            $this->get( 'slug' ) . "_database_version" => "0",

            //SECTION GENERAL --------------------------------------------------------------
            $this->get( 'slug' ) . "_player_border_color" => "#008153",
            $this->get( 'slug' ) . "_player_name_color" => "#008153",
            $this->get( 'slug' ) . "_field_top_margin" => "0",
            $this->get( 'slug' ) . "_field_bottom_margin" => "0",
            $this->get( 'slug' ) . "_field_image" => "4",
            $this->get( 'slug' ) . "_field_image_resolution" => "1",

	    ];
        
    }
    
    public static function get_instance() {

        if ( null == self::$instance ) {
            self::$instance = new self;
        }

        return self::$instance;
            
    }
    
    //retrieve data
    public function get($index){
        return $this->data[$index];
    }
    
}