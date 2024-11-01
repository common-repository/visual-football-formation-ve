<?php

if ( ! current_user_can('manage_options')) {
    wp_die(esc_html__('You do not have sufficient permissions to access this page.', 'visual-football-formation-ve'));
}

?>

<!-- output -->

<div class="wrap">

    <h2><?php esc_html_e('Visual Football Formation VE - Help', 'visual-football-formation-ve'); ?></h2>

    <div id="daext-menu-wrapper">

        <p><?php esc_html_e('Visit the resources below to find your answers or to ask questions directly to the plugin developers.', 'visual-football-formation-ve'); ?></p>
        <ul>
            <li><a href="https://daext.com/doc/visual-football-formation-ve/"><?php esc_html_e('Plugin Documentation', 'visual-football-formation-ve'); ?></a></li>
            <li><a href="https://daext.com/support/"><?php esc_html_e('Support Conditions', 'visual-football-formation-ve'); ?></li>
            <li><a href="https://daext.com"><?php esc_html_e('Developer Website', 'visual-football-formation-ve'); ?></a></li>
            <li><a href="https://wordpress.org/plugins/visual-football-formation-ve/"><?php esc_html_e('WordPress.org Plugin Page', 'visual-football-formation-ve'); ?></a></li>
            <li><a href="https://wordpress.org/support/plugin/visual-football-formation-ve/"><?php esc_html_e('WordPress.org Support Forum', 'visual-football-formation-ve'); ?></a></li>
        </ul>

    </div>

</div>