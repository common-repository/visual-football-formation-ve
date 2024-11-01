<?php

/*
 * this class should be used to work with the public side of wordpress
 */
class Daextvffve_Public{
    
    protected static $instance = null;
    private $shared = null;

    //Store all the shortcode IDs used in the post/page
    private static $shortcode_id_a = array();
    
    private function __construct() {
        
        //assign an instance of the plugin info
        $this->shared = Daextvffve_Shared::get_instance();
        
        //Load public css and js
        add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_styles' ) );
        add_action( 'wp_enqueue_scripts', array( $this, 'en_public_scripts' ) );
        
        //shortcode
        add_shortcode('visual-football-formation-ve',array($this, 'display_formation'));

    }
    
    /*
     * create an instance of this class
     */
    public static function get_instance() {

        if ( null == self::$instance ) {
            self::$instance = new self;
        }

        return self::$instance;
        
    }
    
    /*
     * enqueue public-specific style sheets
     */
    public function enqueue_styles() {

	    //if is set load a google font
	    if( strlen( trim( get_option( $this->shared->get("slug") . "_load_google_font" ) ) )  > 0 ){

		    wp_enqueue_style( $this->shared->get( 'slug' ) . '-google-font',
			    esc_url( get_option( $this->shared->get( 'slug' ) . '_load_google_font' ) ), false );

	    }

    }
    
    /*
     * enqueue public-specific javascipt
     */
    public function en_public_scripts() {

	    //Enqueue the main public JavaScript file
        wp_enqueue_script( $this->shared->get('slug') . '-public-script', $this->shared->get('url') . 'public/assets/js/general.js', array( 'jquery' ), $this->shared->get('ver') );

	    //Add parameters before the script
	    $parameters_script = 'window.DAEXTVFFVE_PARAMETERS = {';
	    $parameters_script .= 'font_size: ' . intval( get_option( $this->shared->get("slug") . "_font_size" ), 10 );
	    $parameters_script .= '};';
	    wp_add_inline_script( $this->shared->get('slug') . '-public-script', $parameters_script, 'before' );

    }
    
    /*
     * Ccallback for the [visual-football-formation-ve] shortcode.
     * 
     * @param array $atts user defined attributes in the shortcode tag
     * @return string the html of a single or a double formation
     */
    public function display_formation( $atts ){

        if( !is_feed() and ( is_single() or is_page() ) ){

            //get the table id
            if(isset($atts['id'])){
                $formation_id = intval($atts['id'], 10);
            }else{
                return '<p>' . esc_html__('Please enter the identifier of the formation.', 'visual-football-formation-ve') . '</p>';
            }

            //get formation data
            global $wpdb; $table_name = $wpdb->prefix . $this->shared->get('slug') . "_formation";
            $safe_sql = $wpdb->prepare("SELECT * FROM $table_name WHERE formation_id = %d ", $formation_id);
            $formation_obj = $wpdb->get_row($safe_sql);

            //terminate if there is no table with the specified id
            if ($formation_obj === NULL) {
                return '<p>' . esc_html__('There is no formation associated with this shortcode.', 'visual-football-formation-ve') . '</p>';
            }

            //terminate if this table id has already been used
            if(in_array($formation_id, self::$shortcode_id_a, true)) {
                return '<p>' . esc_html__("You can't use multiple times the same shortcode.", 'visual-football-formation-ve') . '</p>';
            }

            //store the shortcode id
            self::$shortcode_id_a[] = $formation_id;

            //OUTPUT -----------------------------------------------------------

            $output = '<div id="daextvffve-container-' . intval($formation_obj->formation_id, 10) .'" class="daextvffve-container" style="' . $this->inline_css(".daextvffve-container") . '" >';

            switch (intval(get_option("daextvffve_field_image_resolution"), 10)){
                case 0:
                    $field_resolution = "med";
                    break;
                case 1:
                    $field_resolution = "high";
                    break;
            }

            $output .= '<img class="daextvffve-field-image" src="' . esc_url($this->shared->get('url') .'/public/assets/img/fields/field-' . intval(get_option("daextvffve_field_image"), 10) . "-" . esc_attr($field_resolution) . '.png') . '" style="' . esc_attr($this->inline_css(".daextvffve-field-image")) . '" >';

            //add players
            for($i=1;$i<=11;$i++){

                //set the player status hidden or visible
                if($this->is_player_hidden( $formation_obj->formation_id, $i )){$player_status = "daextvffve-hidden-player";}else{$player_status = "";}

                $output .= '<div class="daextvffve-player '. esc_attr($player_status) . ' daextvffve-player-' . esc_attr($i) . '" style="' . esc_attr($this->image_css_position( $formation_obj->layout_id, $i) . $this->inline_css(".daextvffve-player")) . '" >';

                if( strlen($formation_obj->{"player_image_" . $i}) > 0 ){
                    //player image
                    $output .= '<img class="daextvffve-player-image" src="' . esc_url(stripslashes($formation_obj->{"player_image_" . $i})) .'" style="' . esc_attr($this->inline_css(".daextvffve-player-image")) . '" >';
                }else{
                    //default image
                    $output .= '<img class="daextvffve-player-image" src="' . esc_url($this->shared->get('url') . "/public/assets/img/no-image.png") . '" style="' . esc_attr($this->inline_css(".daextvffve-player-image")) . '" >';
                }

                $output .= '<div class="daextvffve-player-image-overlay" style="' . esc_attr($this->inline_css(".daextvffve-player-image-overlay")) . '" ></div>';

                $output .= '</div>';

                $output .= '<div class="daextvffve-player-name '. esc_attr($player_status) . ' daextvffve-player-name-' . esc_attr($i) . '" style="' . esc_attr($this->name_css_position( $formation_obj->layout_id, $i) . $this->inline_css(".daextvffve-player-name")) . '" >' . esc_html(stripslashes($formation_obj->{"player_name_" . $i})) . '</div>';

            }

            $output .= '</div>';

            return $output;

        }

    }

    /**
     * Write the inline css used to set the position of this player image.
     *
     * @param $layout_id
     * @param $player_number
     * @return string
     */
    public function image_css_position($layout_id, $player_number){

        //get layout data
        global $wpdb;
        $table_name = $wpdb->prefix . "daextvffve_layout";
        $safe_sql = $wpdb->prepare("SELECT * FROM $table_name WHERE layout_id = %d ", $layout_id);
        $layout_obj = $wpdb->get_row($safe_sql);

        //get position
        $player_x = $layout_obj->{"player_x_" . $player_number};
        $player_y = $layout_obj->{"player_y_" . $player_number};

        //convert to percentage
        $player_x = $player_x/400*100;
        $player_y = $player_y/440*100;

        //remove half player in order accept the position from the center ----------

        ////0.1577490774907749 is PLAYER WIDTH/FIELD WIDTH
        //divided by 2 because half of the player should be removed
        $player_x = $player_x - ( 0.1577490774907749 / 2 * 100 );

        ////0.1427378964941569 is PLAYER HEIGHT/FIELD HEIGHT
        //divided by 2 because half of the player should be removed
        $player_y = $player_y - ( 0.1427378964941569 / 2 * 100 );

        //write inline css
        $output = 'left: ' . floatval($player_x) . '% !important;';
        $output .= 'top: ' . floatval($player_y) . '% !important;';

        return $output;
    }

    /**
     * Write the inline css used to set the position of this player name.
     *
     * @param $layout_id
     * @param $player_number
     * @return string
     */
    public function name_css_position($layout_id, $player_number){

        //get layout data
        global $wpdb; $table_name = $wpdb->prefix . "daextvffve_layout";
        $safe_sql = $wpdb->prepare("SELECT * FROM $table_name WHERE layout_id = %d ", $layout_id);
        $layout_obj = $wpdb->get_row($safe_sql);

        //get position
        $player_x = $layout_obj->{"player_x_" . $player_number};
        $player_y = $layout_obj->{"player_y_" . $player_number};

        //convert to percentage
        $player_x = $player_x/400*100;
        $player_y = $player_y/440*100;

        //remove half player in order accept the position from the center ----------

        ////0.1577490774907749 is PLAYER WIDTH/FIELD WIDTH
        //divided by 2 because i need to remove half player
        $player_x = $player_x - ( 0.1577490774907749 / 2 * 100 );

        //i need to remove another half player because the name width is 2x the player width
        $player_x = $player_x - ( 0.1577490774907749 / 2 * 100 );

        ////0.1427378964941569 is PLAYER HEIGHT/FIELD HEIGHT
        //divided by 2 because i need to remove half player
        $player_y = $player_y - ( 0.1427378964941569 / 2 * 100 );

        //move down the y position
        $player_y = (float)( $player_y + 14.9);

        //write inline css
        $output = 'left: ' . floatval($player_x) . '% !important;';
        $output .= 'top: ' . floatval($player_y) . '% !important;';

        return $output;
    }

    /**
     * Returns the inline style of the element based on the given selector
     * @param string $selector
     * @return string The inline style of the element
     */
    public function inline_css($selector){

        switch ($selector){

            case ".daextvffve-container":

                $style = "position: relative !important;" .
                    "margin-top: " . intval(get_option("daextvffve_field_top_margin"),10) . "px !important;" .
                    "margin-bottom: " . intval(get_option("daextvffve_field_bottom_margin"),10) . "px !important;" .
                    "margin-left: 0 !important;" .
                    "margin-right: 0 !important;" .
                    "padding: 0 !important;" .
                    "border: 0 !important;" .
                    "width: 100% !important;" .
                    "max-width: 100% !important;";
                break;

            case ".daextvffve-field-image":
                $style = "width: 100% !important;" .
                    "max-width: 100% !important;" .
                    "border: 0 !important;" .
                    "margin: 0 !important;" .
                    "padding: 0 !important;" .
                    "box-shadow: none !important;";
                break;

            case ".daextvffve-player":

                $style = "position: absolute !important;" .
                    "display: none;" .
                    "background: " . esc_attr(get_option("daextvffve_player_border_color")) . " !important;" .
                    "background-image: -moz-linear-gradient( 120deg, rgba(0,0,0,0.294) 0%, rgba(255,255,255,0) 100%) !important;" .
                    "background-image: -webkit-linear-gradient( 120deg, rgba(0,0,0,0.294) 0%, rgba(255,255,255,0) 100%) !important;" .
                    "background-image: -ms-linear-gradient( 120deg, rgba(0,0,0,0.294) 0%, rgba(255,255,255,0) 100%) !important;" .
                    "padding: 0 !important;" .
                    "border: 0 !important;";
                break;

            case ".daextvffve-player-image-overlay":

                $style = "position: absolute !important;" .
                    "z-index: 0 !important;" .
                    "top: 0 !important;" .
                    "left: 0 !important;" .
                    "padding: 0 !important;" .
                    "border: 0 !important;";
                break;

            case ".daextvffve-player-name":

                $style = "position: absolute !important;" .
                    "text-transform: uppercase !important;" .
                    "text-align: center !important;" .
                    "color: " . esc_attr(get_option("daextvffve_player_name_color")) . " !important;" .
                    "font-family: 'Open Sans', sans-serif !important;" .
                    "font-weight: 800 !important;" .
                    "display: none;" .
                    "z-index: 999999 !important;" .
                    "border: 0 !important;" .
                    "padding: 0 !important;" .
                    "text-decoration: none !important;";

                break;

            case ".daextvffve-player-image":
                $style = "border: 0 !important;" .
                    "padding: 0 !important;" .
                    "margin: 0" .
                    "display: block !important;" .
                    "box-shadow: none !important;";
                break;

        }

        //apply anti div highlight
        $style .= "-webkit-user-select: none !important;".
            "-moz-user-select: none !important;".
            "-ms-user-select: none !important;".
            "-khtml-user-select: none !important;".
            "-o-user-select: none !important;".
            "user-select: none !important;".
            "-webkit-touch-callout: none !important;";

        return $style;

    }

    /**
     * Returns true if this player is hidden.
     * Return false if this player is not hidden.
     *
     * @param int $formation_id
     * @param int $player_number
     * @return bool
     */
    public function is_player_hidden( $formation_id, $player_number ){

        //get layout id of a formation
        $layout_id = $this->get_layout_id( $formation_id );

        //get layout obj
        global $wpdb; $table_name = $wpdb->prefix . "daextvffve_layout";
        $safe_sql = $wpdb->prepare("SELECT * FROM $table_name WHERE layout_id = %d ", $layout_id);
        $layout_obj = $wpdb->get_row($safe_sql);

        if($layout_obj->{"player_show_" . $player_number}){
            return false;
        }else{
            return true;
        }

    }

    /**
     * Returns the layout_id of a formation.
     *
     * @param int $formation_id
     * @return int The layout id
     */
    public function get_layout_id( $formation_id ){

        //get layout id of a formation
        global $wpdb;
        $table_name = $wpdb->prefix . "daextvffve_formation";
        $safe_sql = $wpdb->prepare("SELECT layout_id FROM $table_name WHERE formation_id = %d ", $formation_id);
        $formation_obj = $wpdb->get_row($safe_sql);

        return $formation_obj->layout_id;

    }
    
}