<?php

//menu layouts view

if ( !current_user_can( 'edit_posts' ) )  {
	wp_die( esc_html__( 'You do not have sufficient permissions to access this page.', 'visual-football-formation-ve') );
}

?>

<!-- process data -->

<?php

//Initialize variables -------------------------------------------------------------------------------------------------
$dismissible_notice_a = [];

//Preliminary operations -----------------------------------------------------------------------------------------------
global $wpdb;

//Sanitization ---------------------------------------------------------------------------------------------

//Actions
$data['edit_id'] = isset($_GET['edit_id']) ? intval($_GET['edit_id'], 10) : null;
$data['delete_id'] = isset($_POST['delete_id']) ? intval($_POST['delete_id'], 10) : null;
$data['clone_id'] = isset($_POST['clone_id']) ? intval($_POST['clone_id'], 10) : null;
$data['update_id']    = isset( $_POST['update_id'] ) ? intval( $_POST['update_id'], 10 ) : null;
$data['form_submitted']    = isset( $_POST['form_submitted'] ) ? intval( $_POST['form_submitted'], 10 ) : null;

//Filter and search data
$data['s'] = isset($_GET['s']) ? sanitize_text_field($_GET['s']) : null;

//Form data
$data['layout_id'] = isset($_POST['update_id']) ? intval($_POST['update_id'], 10) : null;
$data['description'] = isset($_POST['description']) ? sanitize_text_field($_POST['description']) : null;
for($i=1;$i<=11;$i++){
	$data['player_x_' . $i] = isset($_POST['player_x_' . $i]) ? intval($_POST['player_x_' . $i], 10) : null;
	$data['player_y_' . $i] = isset($_POST['player_y_' . $i]) ? intval($_POST['player_y_' . $i], 10) : null;
	$data['player_show_' . $i] = isset($_POST['player_show_' . $i]) ? intval($_POST['player_show_' . $i], 10) : null;
}

//Validation -----------------------------------------------------------------------------------------------

if( !is_null( $data['update_id'] ) or !is_null($data['form_submitted']) ) {

	//validation on "description"
	if ( mb_strlen( trim( $data['description'] ) ) === 0 or mb_strlen( trim( $data['description'] ) ) > 100 ) {
		$dismissible_notice_a[] = [
			'message' => __( 'Please enter a valid value in the "Description" field.', 'visual-football-formation-ve'),
			'class' => 'error'
		];
		$invalid_data         = true;
	}

}

//update ---------------------------------------------------------------
if( !is_null($data['update_id']) and !isset($invalid_data) ){

	//update the database
	$table_name = $wpdb->prefix . $this->shared->get('slug') . "_layout";
	$safe_sql = $wpdb->prepare("UPDATE $table_name SET 
        description = %s,
        player_x_1 = %d,
        player_y_1 = %d,
        player_x_2 = %d,
        player_y_2 = %d,
        player_x_3 = %d,
        player_y_3 = %d,
        player_x_4 = %d,
        player_y_4 = %d,
        player_x_5 = %d,
        player_y_5 = %d,
        player_x_6 = %d,
        player_y_6 = %d,
        player_x_7 = %d,
        player_y_7 = %d,
        player_x_8 = %d,
        player_y_8 = %d,
        player_x_9 = %d,
        player_y_9 = %d,
        player_x_10 = %d,
        player_y_10 = %d,
        player_x_11 = %d,
        player_y_11 = %d,
        player_show_1 = %d,
        player_show_2 = %d,
        player_show_3 = %d,
        player_show_4 = %d,
        player_show_5 = %d,
        player_show_6 = %d,
        player_show_7 = %d,
        player_show_8 = %d,
        player_show_9 = %d,
        player_show_10 = %d,
        player_show_11 = %d
        WHERE layout_id = %d",
		$data['description'],
		$data['player_x_1'],
		$data['player_y_1'],
		$data['player_x_2'],
		$data['player_y_2'],
		$data['player_x_3'],
		$data['player_y_3'],
		$data['player_x_4'],
		$data['player_y_4'],
		$data['player_x_5'],
		$data['player_y_5'],
		$data['player_x_6'],
		$data['player_y_6'],
		$data['player_x_7'],
		$data['player_y_7'],
		$data['player_x_8'],
		$data['player_y_8'],
		$data['player_x_9'],
		$data['player_y_9'],
		$data['player_x_10'],
		$data['player_y_10'],
		$data['player_x_11'],
		$data['player_y_11'],
		$data['player_show_1'],
		$data['player_show_2'],
		$data['player_show_3'],
		$data['player_show_4'],
		$data['player_show_5'],
		$data['player_show_6'],
		$data['player_show_7'],
		$data['player_show_8'],
		$data['player_show_9'],
		$data['player_show_10'],
		$data['player_show_11'],
		$data['layout_id'] );

	$query_result = $wpdb->query( $safe_sql );

	if($query_result !== false){
		$dismissible_notice_a[] = [
			'message' => __('The layout has been successfully updated.', 'visual-football-formation-ve'),
			'class' => 'updated'
		];
	}

}else{

	//add ------------------------------------------------------------------
	if( !is_null($data['form_submitted']) and !isset($invalid_data) ){

		//insert into the database
		$table_name = $wpdb->prefix . $this->shared->get('slug') . "_layout";
		$safe_sql = $wpdb->prepare("INSERT INTO $table_name SET 
            description = %s,
            player_x_1 = %d,
            player_y_1 = %d,
            player_x_2 = %d,
            player_y_2 = %d,
            player_x_3 = %d,
            player_y_3 = %d,
            player_x_4 = %d,
            player_y_4 = %d,
            player_x_5 = %d,
            player_y_5 = %d,
            player_x_6 = %d,
            player_y_6 = %d,
            player_x_7 = %d,
            player_y_7 = %d,
            player_x_8 = %d,
            player_y_8 = %d,
            player_x_9 = %d,
            player_y_9 = %d,
            player_x_10 = %d,
            player_y_10 = %d,
            player_x_11 = %d,
            player_y_11 = %d,
            player_show_1 = %d,
            player_show_2 = %d,
            player_show_3 = %d,
            player_show_4 = %d,
            player_show_5 = %d,
            player_show_6 = %d,
            player_show_7 = %d,
            player_show_8 = %d,
            player_show_9 = %d,
            player_show_10 = %d,
            player_show_11 = %d",
			$data['description'],
			$data['player_x_1'],
			$data['player_y_1'],
			$data['player_x_2'],
			$data['player_y_2'],
			$data['player_x_3'],
			$data['player_y_3'],
			$data['player_x_4'],
			$data['player_y_4'],
			$data['player_x_5'],
			$data['player_y_5'],
			$data['player_x_6'],
			$data['player_y_6'],
			$data['player_x_7'],
			$data['player_y_7'],
			$data['player_x_8'],
			$data['player_y_8'],
			$data['player_x_9'],
			$data['player_y_9'],
			$data['player_x_10'],
			$data['player_y_10'],
			$data['player_x_11'],
			$data['player_y_11'],
			$data['player_show_1'],
			$data['player_show_2'],
			$data['player_show_3'],
			$data['player_show_4'],
			$data['player_show_5'],
			$data['player_show_6'],
			$data['player_show_7'],
			$data['player_show_8'],
			$data['player_show_9'],
			$data['player_show_10'],
			$data['player_show_11'],
			);

		$query_result = $wpdb->query( $safe_sql );

		if($query_result !== false){
			$dismissible_notice_a[] = [
				'message' => __('The layout has been successfully added.', 'visual-football-formation-ve'),
				'class' => 'updated'
			];
		}

	}

}

//delete an item
if( !is_null($data['delete_id']) ){

    $not_deletable = false;

	//delete this layout only if it's not used by any formation and it's not a default layout.
	if( $this->ut_layout_is_used($data['delete_id']) ){

		$dismissible_notice_a[] = [
			'message' => __("This layout is associated with one or more formations and can't be deleted.", 'visual-football-formation-ve'),
			'class' => 'error'
		];
        $not_deletable = true;

    }

	if($not_deletable === false){

        $table_name = $wpdb->prefix . $this->shared->get('slug') . "_layout";
        $safe_sql = $wpdb->prepare("DELETE FROM $table_name WHERE layout_id = %d ", $data['delete_id']);
		$query_result = $wpdb->query( $safe_sql );

		if($query_result !== false){
			$dismissible_notice_a[] = [
				'message' => __('The layout has been successfully deleted.', 'visual-football-formation-ve'),
				'class' => 'updated'
			];
		}

    }

}

//clone a table
if (!is_null($data['clone_id'])) {

	//clone a table
	$table_name = $wpdb->prefix . $this->shared->get('slug') . "_layout";
	$wpdb->query("CREATE TEMPORARY TABLE tmptable_1 SELECT * FROM $table_name WHERE layout_id = " . $data['clone_id']);
	$wpdb->query("UPDATE tmptable_1 SET layout_id = NULL");
	$wpdb->query("INSERT INTO $table_name SELECT * FROM tmptable_1");
	$wpdb->query("DROP TEMPORARY TABLE IF EXISTS tmptable_1");

}

//get the layout data
if(!is_null($data['edit_id'])){

	$table_name = $wpdb->prefix . $this->shared->get('slug') . "_layout";
	$safe_sql = $wpdb->prepare("SELECT * FROM $table_name WHERE layout_id = %d ", $data['edit_id']);
	$layout_obj = $wpdb->get_row($safe_sql);

}

?>

<!-- output -->

<div class="wrap">

    <div id="daext-header-wrapper" class="daext-clearfix">

        <h2><?php esc_html_e('Visual Football Formation VE - Formations', 'visual-football-formation-ve'); ?></h2>

        <form action="admin.php" method="get" id="daext-search-form">

            <input type="hidden" name="page" value="daextvffve-layouts">

            <p><?php esc_html_e('Perform your Search', 'visual-football-formation-ve'); ?></p>

			<?php
			if ( ! is_null( $data['s'] ) and mb_strlen( trim( $data['s'] ) ) > 0 ) {
				$search_string = $data['s'];
			} else {
				$search_string = '';
			}

			?>

            <input type="text" name="s"
                   value="<?php echo esc_attr(stripslashes($search_string)); ?>" autocomplete="off" maxlength="255">
            <input type="submit" value="">

        </form>

    </div>

    <div id="daext-menu-wrapper">

	    <?php $this->dismissible_notice($dismissible_notice_a); ?>

        <!-- table -->

		<?php

		//create the query part used to filter the results when a search is performed
		if (!is_null($data['s']) and mb_strlen(trim($data['s'])) > 0) {

			//create the query part used to filter the results when a search is performed
			$filter = $wpdb->prepare('WHERE (description LIKE %s)',
				'%' . $data['s'] . '%');

		}else{
			$filter = '';
		}

		//retrieve the total number of layouts
		$table_name=$wpdb->prefix . $this->shared->get('slug') . "_layout";
		$total_items = $wpdb->get_var( "SELECT COUNT(*) FROM $table_name $filter");

		//Initialize the pagination class
		require_once( $this->shared->get('dir') . '/admin/inc/class-daextvffve-pagination.php' );
		$pag = new Daextvffve_Pagination();
		$pag->set_total_items( $total_items );//Set the total number of items
		$pag->set_record_per_page( 10 ); //Set records per page
		$pag->set_target_page( "admin.php?page=" . $this->shared->get('slug') . "-layouts" );//Set target page
		$pag->set_current_page();//set the current page number from $_GET

		?>

        <!-- Query the database -->
		<?php
		$query_limit = $pag->query_limit();
		$results = $wpdb->get_results("SELECT * FROM $table_name $filter ORDER BY layout_id DESC $query_limit ", ARRAY_A); ?>

		<?php if( count($results) > 0 ) : ?>

            <div class="daext-items-container">

                <!-- list of tables -->
                <table class="daext-items">
                    <thead>
                    <tr>
                        <th>
                            <div><?php esc_html_e( 'ID', 'visual-football-formation-ve'); ?></div>
                            <div class="help-icon" title="<?php esc_attr_e( 'The ID of the layout.', 'visual-football-formation-ve'); ?>"></div>
                        </th>
                        <th>
                            <div><?php esc_html_e( 'Description', 'visual-football-formation-ve'); ?></div>
                            <div class="help-icon"
                                 title="<?php esc_attr_e( 'The description of the layout.', 'visual-football-formation-ve'); ?>"></div>
                        </th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>

					<?php foreach ( $results as $result ) : ?>
                        <tr>
                            <td><?php echo intval( $result['layout_id'], 10 ); ?></td>
                            <td><?php echo esc_attr( stripslashes( $result['description'] ) ); ?></td>
                            <td class="icons-container">
                                <form method="POST"
                                      action="admin.php?page=<?php echo esc_attr($this->shared->get( 'slug' )); ?>-layouts">
                                    <input type="hidden" name="clone_id" value="<?php echo intval( $result['layout_id'], 10 ); ?>">
                                    <input class="menu-icon clone help-icon" type="submit" value="">
                                </form>
                                <a class="menu-icon edit"
                                   href="admin.php?page=<?php echo esc_attr($this->shared->get( 'slug' )); ?>-layouts&edit_id=<?php echo intval( $result['layout_id'],
									   10 ); ?>"></a>
                                <form id="form-delete-<?php echo intval( $result['layout_id'], 10 ); ?>" method="POST"
                                      action="admin.php?page=<?php echo esc_attr($this->shared->get( 'slug' )); ?>-layouts">
                                    <input type="hidden" value="<?php echo intval( $result['layout_id'], 10 ); ?>" name="delete_id">
                                    <input class="menu-icon delete" type="submit" value="">
                                </form>
                            </td>
                        </tr>
					<?php endforeach; ?>

                    </tbody>

                </table>

            </div>

            <!-- Display the pagination -->
			<?php if($pag->total_items > 0) : ?>

                <div class="daext-tablenav daext-clearfix">
                    <div class="daext-tablenav-pages">
                        <span class="daext-displaying-num"><?php echo $pag->total_items; ?> <?php esc_html_e('items', 'visual-football-formation-ve'); ?></span>
						<?php $pag->show(); ?>
                    </div>
                </div>

			<?php endif; ?>

		<?php else : ?>

			<?php

			if (mb_strlen(trim($filter)) > 0) {
				echo '<div class="error settings-error notice is-dismissible below-h2"><p>' . esc_html__('There are no results that match your filter.', 'visual-football-formation-ve') . '</p></div>';
			}

			?>

		<?php endif; ?>

        <form method="POST" action="admin.php?page=<?php echo esc_attr($this->shared->get('slug')); ?>-layouts" >

            <input type="hidden" value="1" name="form_submitted">

            <div class="daext-form-container">

				<?php if(!is_null($data['edit_id'])) : ?>

                    <!-- Edit a layout -->

                    <div class="daext-form-title"><?php esc_html_e('Edit Layout', 'visual-football-formation-ve'); ?> <?php echo intval($layout_obj->layout_id, 10); ?></div>

                    <table class="daext-form daext-form-table">

                        <input type="hidden" name="update_id" value="<?php echo intval($layout_obj->layout_id, 10); ?>" />

                        <?php for($i=1;$i<=11;$i++) : ?>

                            <!-- Player X 1 -->
                            <input type="hidden" id="player-x-<?php echo esc_attr($i); ?>" maxlength="6" name="player_x_<?php echo $i; ?>" value="<?php echo esc_attr($layout_obj->{'player_x_' . $i}); ?>" />

                            <!-- Player Y 1 -->
                            <input type="hidden" id="player-y-<?php echo esc_attr($i); ?>" maxlength="6" name="player_y_<?php echo $i; ?>" value="<?php echo esc_attr($layout_obj->{'player_y_' . $i}); ?>" />

                        <?php endfor; ?>

                        <!-- Description -->
                        <tr valign="top">
                            <th><label for="description"><?php esc_html_e('Description', 'visual-football-formation-ve'); ?></label></th>
                            <td>
                                <input value="<?php echo esc_attr(stripslashes($layout_obj->description)); ?>" type="text"
                                       id="description" maxlength="255" size="30" name="description"/>
                                <div class="help-icon"
                                     title="<?php esc_attr_e('The description of the layout.', 'visual-football-formation-ve'); ?>"></div>
                            </td>
                        </tr>

                        <!-- Field -->
                        <tr valign="top" class="daextvffve-draggable-field-container">
                            <th><label for="field"><?php esc_html_e('Field', 'visual-football-formation-ve'); ?></label></th>
                            <td>

                                <div id="daextvffve-container" class="daext-display-none">

                                    <!-- Field -->
                                    <div id="daextvffve-draggable-field" class="daextvffve-clearfix" >

                                        <div id="daextvffve-containment-wrapper"></div>

                                        <?php for($i=1;$i<=11;$i++) : ?>

                                            <div id="daextvffve-field-player-<?php echo esc_attr($i); ?>" class="daextvffve-field-player" data-id="<?php echo esc_attr($i); ?>"><?php echo esc_html($i); ?></div>

                                        <?php endfor; ?>

                                    </div>

                                    <!-- Positions -->
                                    <div id="daextvffve-positions">

                                        <?php for($i=1;$i<=11;$i++) : ?>

                                            <div class="daextvffve-single-position">X<?php echo intval($i, 10); ?>: <span id="position-player-x-<?php echo $i; ?>"><?php echo intval($layout_obj->{'player_x_' . $i}, 10); ?></span><br></div>
                                            <div class="daextvffve-single-position">Y<?php echo intval($i, 10); ?>: <span id="position-player-y-<?php echo $i; ?>"><?php echo intval($layout_obj->{'player_y_' . $i}, 10); ?></span><br></div>

                                        <?php endfor; ?>

                                    </div>

                                </div>

                            </td>
                        </tr>

                        <!-- Advanced Options ---------------------------------------------------------------------- -->
                        <tr class="group-trigger" data-trigger-target="advanced-options">
                            <th class="group-title"><?php esc_html_e('Advanced', 'visual-football-formation-ve'); ?></th>
                            <td>
                                <div class="expand-icon"></div>
                            </td>
                        </tr>

                        <?php for($i=1;$i<=11;$i++) : ?>

                            <!-- Show Player X -->
                            <tr class="advanced-options">
                                <th scope="row"><?php esc_html_e('Player', 'visual-football-formation-ve'); ?> <?php esc_html($i); ?></th>
                                <td>
                                    <select data-id="<?php echo esc_attr($i); ?>" id="player-show-<?php echo esc_attr($i); ?>" name="player_show_<?php echo esc_attr($i); ?>" class="player-show daext-display-none">
                                        <option value="0" <?php selected($layout_obj->{'player_show_' . $i}, 0); ?>><?php esc_html_e('Hide', 'visual-football-formation-ve'); ?></option>
                                        <option value="1" <?php selected($layout_obj->{'player_show_' . $i}, 1); ?>><?php esc_html_e('Show', 'visual-football-formation-ve'); ?></option>
                                    </select>
                                    <div class="help-icon" title='<?php esc_attr_e('This option determines if the player should be displayed.', 'visual-football-formation-ve'); ?>'></div>
                                </td>
                            </tr>

                        <?php endfor; ?>

                    </table>

                    <!-- submit button -->
                    <div class="daext-form-action">
                        <input class="button" type="submit" value="<?php esc_attr_e('Update Layout', 'visual-football-formation-ve'); ?>" >
                        <input id="cancel" class="button" type="submit" value="<?php esc_attr_e('Cancel', 'visual-football-formation-ve'); ?>">
                    </div>

			    <?php else : ?>

                    <!-- Create new layout -->

                    <div class="daext-form-title"><?php esc_html_e('Create New Layout', 'visual-football-formation-ve'); ?></div>

                    <table class="daext-form daext-form-table">

                        <?php

                        $initial_positions = [
                            [
                                'x' => 201,
                                'y' => 370
                            ],
                            [
                                'x' => 56,
                                'y' => 245
                            ],
                            [
                                'x' => 159,
                                'y' => 274
                            ],
                            [
                                'x' => 245,
                                'y' => 274
                            ],
                            [
                                'x' => 346,
                                'y' => 245
                            ],
                            [
                                'x' => 56,
                                'y' => 124
                            ],
                            [
                                'x' => 159,
                                'y' => 157
                            ],
                            [
                                'x' => 245,
                                'y' => 157
                            ],
                            [
                                'x' => 346,
                                'y' => 124
                            ],
                            [
                                'x' => 159,
                                'y' => 45
                            ],
                            [
                                'x' => 245,
                                'y' => 45
                            ],
                        ];

                        ?>

                        <?php for($i=1;$i<=11;$i++) : ?>

                            <!-- Player X 1 -->
                            <input type="hidden" id="player-x-<?php echo $i; ?>" maxlength="6" name="player_x_<?php echo esc_attr($i); ?>" value="<?php echo esc_attr($initial_positions[$i-1]['x']); ?>" />

                            <!-- Player Y 1 -->
                            <input type="hidden" id="player-y-<?php echo $i; ?>" maxlength="6" name="player_y_<?php echo esc_attr($i); ?>" value="<?php echo esc_attr($initial_positions[$i-1]['y']); ?>" />

                        <?php endfor; ?>
                       

                        <!-- Description -->
                        <tr valign="top">
                            <th><label for="description"><?php esc_html_e('Description', 'visual-football-formation-ve'); ?></label></th>
                            <td>
                                <input type="text"
                                       id="description" maxlength="255" size="30" name="description"/>
                                <div class="help-icon"
                                     title="<?php esc_attr_e('The description of the layout.', 'visual-football-formation-ve'); ?>"></div>
                            </td>
                        </tr>
                        
                        <!-- Field -->
                        <tr valign="top" class="daextvffve-draggable-field-container">
                            <th><label for="field"><?php esc_html_e('Field', 'visual-football-formation-ve'); ?></label></th>
                            <td>

                                <div id="daextvffve-container" class="daext-display-none">

                                    <!-- Field -->
                                    <div id="daextvffve-draggable-field" class="daextvffve-clearfix">

                                        <div id="daextvffve-containment-wrapper"></div>

                                        <?php for($i=1;$i<=11;$i++) : ?>

                                            <div id="daextvffve-field-player-<?php echo esc_attr($i); ?>" class="daextvffve-field-player" data-id="<?php echo esc_attr($i); ?>"><?php echo esc_html($i); ?></div>

                                        <?php endfor; ?>


                                    </div>

                                    <!-- Positions -->

                                    <div id="daextvffve-positions">

                                        <?php for($i=1;$i<=11;$i++) : ?>

                                            <div class="daextvffve-single-position">X<?php echo intval($i, 10); ?>: <span id="position-player-x-<?php echo $i; ?>"><?php echo intval($initial_positions[$i-1]['x'], 10); ?></span><br></div>
                                            <div class="daextvffve-single-position">Y<?php echo intval($i, 10); ?>: <span id="position-player-y-<?php echo $i; ?>"><?php echo intval($initial_positions[$i-1]['y'], 10); ?></span><br></div>

                                        <?php endfor; ?>


                                    </div>

                                </div>

                            </td>
                        </tr>
                        
                        <!-- Advanced Options ---------------------------------------------------------------------- -->
                        <tr class="group-trigger" data-trigger-target="advanced-options">
                            <th class="group-title"><?php esc_html_e('Advanced', 'visual-football-formation-ve'); ?></th>
                            <td>
                                <div class="expand-icon"></div>
                            </td>
                        </tr>

                        <?php for($i=1;$i<=11;$i++) : ?>

                            <!-- Show Player X -->
                            <tr class="advanced-options">
                                <th scope="row"><?php esc_html_e('Player', 'visual-football-formation-ve'); ?> <?php esc_html($i); ?></th>
                                <td>
                                    <select data-id="<?php echo esc_attr($i); ?>" id="player-show-<?php echo esc_attr($i); ?>" name="player_show_<?php echo esc_attr($i); ?>" class="player-show daext-display-none">
                                        <option value="0"><?php esc_html_e('Hide', 'visual-football-formation-ve'); ?></option>
                                        <option value="1" selected="selected"><?php esc_html_e('Show', 'visual-football-formation-ve'); ?></option>
                                    </select>
                                    <div class="help-icon" title='<?php esc_attr_e('This option determines if the player should be displayed.', 'visual-football-formation-ve'); ?>'></div>
                                </td>
                            </tr>

                        <?php endfor; ?>
                        
                    </table>
                
                    <!-- submit button -->
                    <div class="daext-form-action">
                        <input class="button" type="submit" value="<?php esc_attr_e('Add Layout', 'visual-football-formation-ve'); ?>" >
                    </div>

			    <?php endif; ?>

            </div>

        </form>

    </div>

</div>

<!-- Dialog Confirm -->
<div id="dialog-confirm" title="<?php esc_attr_e('Delete the layout?', 'visual-football-formation-ve'); ?>" class="display-none">
    <p><?php esc_attr_e('This layout will be permanently deleted and cannot be recovered. Are you sure?', 'visual-football-formation-ve'); ?></p>
</div>