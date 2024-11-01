<?php

/**
 * This class adds the options with the related callbacks and validations.
 */
class Daextvffve_Menu_Options {

	private $shared = null;

	public function __construct( $shared ) {

		//assign an instance of the plugin info
		$this->shared = $shared;

	}

	public function register_options() {

        //SECTION RECIPE LABELS -----------------------------------------------------------
        add_settings_section(
            'daextvffve_general_settings_section',
            null,
            null,
            'daextvffve_general_options'
        );

        //daextvffve_player_border_color
        add_settings_field(
            'daextvffve_player_border_color',
            esc_html__('Player Border Color', 'visual-football-formation-ve'),
            array($this, 'player_border_color_callback'),
            'daextvffve_general_options',
            'daextvffve_general_settings_section'
        );

        register_setting(
            'daextvffve_general_options',
            'daextvffve_player_border_color',
            array($this, 'player_border_color_validation')
        );

        //daextvffve_player_name_color
        add_settings_field(
            'daextvffve_player_name_color',
            esc_html__('Player Name Color', 'visual-football-formation-ve'),
            array($this, 'player_name_color_callback'),
            'daextvffve_general_options',
            'daextvffve_general_settings_section'
        );

        register_setting(
            'daextvffve_general_options',
            'daextvffve_player_name_color',
            array($this, 'player_name_color_validation')
        );

        //daextvffve_field_top_margin
        add_settings_field(
            'daextvffve_field_top_margin',
            esc_html__('Field Top Margin', 'visual-football-formation-ve'),
            array($this, 'field_top_margin_callback'),
            'daextvffve_general_options',
            'daextvffve_general_settings_section'
        );

        register_setting(
            'daextvffve_general_options',
            'daextvffve_field_top_margin',
            array($this, 'field_top_margin_validation')
        );

        //daextvffve_field_bottom_margin
        add_settings_field(
            'daextvffve_field_bottom_margin',
            esc_html__('Field Bottom Margin', 'visual-football-formation-ve'),
            array($this, 'field_bottom_margin_callback'),
            'daextvffve_general_options',
            'daextvffve_general_settings_section'
        );

        register_setting(
            'daextvffve_general_options',
            'daextvffve_field_bottom_margin',
            array($this, 'field_bottom_margin_validation')
        );

        //daextvffve_field_image
        add_settings_field(
            'daextvffve_field_image',
            esc_html__('Field Image', 'visual-football-formation-ve'),
            array($this, 'field_image_callback'),
            'daextvffve_general_options',
            'daextvffve_general_settings_section'
        );

        register_setting(
            'daextvffve_general_options',
            'daextvffve_field_image',
            array($this, 'field_image_validation')
        );

        //daextvffve_field_image_resolution
        add_settings_field(
            'daextvffve_field_image_resolution',
            esc_html__('Field Image Resolution', 'visual-football-formation-ve'),
            array($this, 'field_image_resolution_callback'),
            'daextvffve_general_options',
            'daextvffve_general_settings_section'
        );

        register_setting(
            'daextvffve_general_options',
            'daextvffve_field_image_resolution',
            array($this, 'field_image_resolution_validation')
        );

	}

//SECTION GENERAL --------------------------------------------------------------

    function general_settings_section_callback() {}

    function player_border_color_callback() {

        $html = '<input type="text" id="daextvffve_player_border_color" name="daextvffve_player_border_color" value="'. esc_attr(get_option('daextvffve_player_border_color')) .'" class="wp-color-picker" maxlength="7" />';
        $html .= '<div class="help-icon" title="' . esc_attr__( 'The border color of the player.', 'visual-football-formation-ve') . '"></div>';
        echo $html;

    }

    public function player_border_color_validation( $input ) {

        return sanitize_hex_color( $input );

    }

    function player_name_color_callback() {

        $html = '<input type="text" id="daextvffve_player_name_color" name="daextvffve_player_name_color" value="'. esc_attr(get_option('daextvffve_player_name_color')) .'" class="wp-color-picker" maxlength="7" />';
        $html .= '<div class="help-icon" title="' . esc_attr__( 'The text color of the player.', 'visual-football-formation-ve') . '"></div>';
        echo $html;

    }

    public function player_name_color_validation( $input ) {

        return sanitize_hex_color( $input );

    }

    function field_top_margin_callback() {

        $html = '<input type="text" id="daextvffve_field_top_margin" name="daextvffve_field_top_margin" value="'. esc_attr(get_option('daextvffve_field_top_margin')) .'" maxlength="4"/>';
        $html .= '<div class="help-icon" title="' . esc_attr__( 'The top margin of the field in pixels.', 'visual-football-formation-ve') . '"></div>';
        echo $html;
    }

    public function field_top_margin_validation( $input ) {

        return intval( $input, 10 );

    }

    function field_bottom_margin_callback() {

        $html = '<input type="text" id="daextvffve_field_bottom_margin" name="daextvffve_field_bottom_margin" value="'. esc_attr(get_option('daextvffve_field_bottom_margin')) .'" maxlength="4"/>';
        $html .= '<div class="help-icon" title="' . esc_attr__( 'The bottom margin of the field in pixels.', 'visual-football-formation-ve') . '"></div>';
        echo $html;
    }

    public function field_bottom_margin_validation( $input ) {

        return intval( $input, 10 );

    }

    function field_image_callback() {

        $html = '<select id="daextvffve_field_image" name="daextvffve_field_image" class="daext-display-none">';
        $html .= '<option value="1"' . selected( get_option('daextvffve_field_image'), '1', false) . '>' . esc_html__('Resolution Blue', 'visual-football-formation-ve') . '</option>';
        $html .= '<option value="2"' . selected( get_option('daextvffve_field_image'), '2', false) . '>' . esc_html__('Blumine', 'visual-football-formation-ve') . '</option>';
        $html .= '<option value="3"' . selected( get_option('daextvffve_field_image'), '3', false) . '>' . esc_html__('Regal Blue', 'visual-football-formation-ve') . '</option>';
        $html .= '<option value="4"' . selected( get_option('daextvffve_field_image'), '4', false) . '>' . esc_html__('Kaitoke Green', 'visual-football-formation-ve') . '</option>';
        $html .= '<option value="5"' . selected( get_option('daextvffve_field_image'), '5', false) . '>' . esc_html__('Crusoe', 'visual-football-formation-ve') . '</option>';
        $html .= '<option value="6"' . selected( get_option('daextvffve_field_image'), '6', false) . '>' . esc_html__('Charade', 'visual-football-formation-ve') . '</option>';
        $html .= '</select>';
        $html .= '<div class="help-icon" title="' . esc_attr__( 'The image of the field.', 'visual-football-formation-ve') . '"></div>';

        echo $html;

    }

    public function field_image_validation( $input ) {

        return intval( $input, 10 );

    }

    function field_image_resolution_callback() {

		$temp = get_option('daextvffve_field_resolution');

        $html = '<select id="daextvffve_field_image_resolution" name="daextvffve_field_image_resolution" class="daext-display-none">';
        $html .= '<option value="0"' . selected( get_option('daextvffve_field_image_resolution'), '0', false) . '>' . esc_html__('Medium (1084 x 1198 )', 'visual-football-formation-ve') . '</option>';
        $html .= '<option value="1"' . selected( get_option('daextvffve_field_image_resolution'), '1', false) . '>' . esc_html__('High (2168 x 2396)', 'visual-football-formation-ve') . '</option>';
        $html .= '</select>';
        $html .= '<div class="help-icon" title="' . esc_attr__( 'The resolution of the image of the field.', 'visual-football-formation-ve') . '"></div>';

        echo $html;

    }

    public function field_image_resolution_validation( $input ) {

        return intval( $input, 10 );

    }

}