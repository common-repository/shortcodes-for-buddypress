<?php
/**
	 * Include EDD sell services template file.
	 *
	 * @since    1.0.0
	 */
	function buddypress_shortcodes_template( $file_name ) {

		$template_name = 'shortcodes-for-buddypress/' . $file_name;

		if ( file_exists( STYLESHEETPATH . '/' . $template_name ) ) {

			include STYLESHEETPATH . '/' . $template_name;

		} elseif ( file_exists( TEMPLATEPATH . '/' . $template_name ) ) {

			include TEMPLATEPATH . '/' . $template_name;

		} else {

			include SHORTCODES_FOR_BUDDYPRESS_PLUGIN_DIR . 'templates/' . $file_name;
		}
	}