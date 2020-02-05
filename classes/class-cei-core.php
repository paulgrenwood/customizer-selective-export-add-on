<?php

/**
 * The main export/import class.
 *
 * @since 0.1
 */
final class CEI_Core {

	/**
	 * An array of core options that shouldn't be imported.
	 *
	 * @since 0.3
	 * @access private
	 * @var array $core_options
	 */
	static private $core_options = array(
		'blogname',
		'blogdescription',
		'show_on_front',
		'page_on_front',
		'page_for_posts',
	);
	
	static private $keys_optout__typography = array(
		'fl-topbar-bg-color',
		'fl-topbar-text-color',
		'fl-topbar-link-color',
		'fl-topbar-hover-color',
		'fl-header-bg-color',
		'fl-header-text-color',
		'fl-header-link-color',
		'fl-header-hover-color',
		'fl-nav-bg-color',
		'fl-nav-text-color',
		'fl-nav-link-color',
		'fl-nav-hover-color',
		'fl-footer-widgets-bg-color',
		'fl-footer-widgets-text-color',
		'fl-footer-widgets-link-color',
		'fl-footer-widgets-hover-color',
		'fl-footer-bg-color',
		'fl-footer-text-color',
		'fl-footer-link-color',
		'fl-footer-hover-color',
		'nav_menu_locations',
		'custom_css_post_id',
		'gwstandard__intro_text__font_size',
		'gwstandard__body_font__margin_bottom',
		'gwstandard__intro_text__margin_bottom',
		'gwstandard__small_text__line_height',
		'gwstandard__small_text__margin_bottom',
		'fl-content-width',
		'fl-body-bg-color',
		'fl-button-style',
		'b42s__blockquote__color',
		'fl-title-text-color',
		'fl-body-text-color',
		'fl-heading-text-color'
	);
	
	static private $keys_optin__typography = array(
		'fl-body-font-size',
		'fl-body-font-size_medium',
		'fl-body-font-size_mobile',
		'fl-body-line-height',
		'fl-body-line-height_medium',
		'fl-body-line-height_mobile',
		'fl-body-font-family',
		'fl-body-font-weight',
		'b42s__body_font__margin_bottom',
		'b42s__body_font__margin_bottom_medium',
		'b42s__body_font__margin_bottom_mobile',
		'b42s__intro_text__font_size',
		'b42s__intro_text__font_size_medium',
		'b42s__intro_text__font_size_mobile',
		'b42s__intro_text__line_height',
		'b42s__intro_text__line_height_medium',
		'b42s__intro_text__line_height_mobile',
		'b42s__intro_text__margin_bottom',
		'b42s__intro_text__margin_bottom_medium',
		'b42s__intro_text__margin_bottom_mobile',
		'b42s__intro_text_alt__font_size',
		'b42s__intro_text_alt__font_size_medium',
		'b42s__intro_text_alt__font_size_mobile',
		'b42s__intro_text_alt__line_height',
		'b42s__intro_text_alt__line_height_medium',
		'b42s__intro_text_alt__line_height_mobile',
		'b42s__intro_text_alt__margin_bottom',
		'b42s__intro_text_alt__margin_bottom_medium',
		'b42s__intro_text_alt__margin_bottom_mobile',
		'b42s__small_text__font_size',
		'b42s__small_text__font_size_medium',
		'b42s__small_text__font_size_mobile',
		'b42s__small_text__line_height',
		'b42s__small_text__line_height_medium',
		'b42s__small_text__line_height_mobile',
		'b42s__small_text__margin_bottom',
		'b42s__small_text__margin_bottom_medium',
		'b42s__small_text__margin_bottom_mobile',
		'b42s__header_nav__font_format',
		'b42s__header_nav__font_weight',
		'b42s__header_nav__font_size',
		'b42s__header_nav__font_size_medium',
		'b42s__header_nav__font_size_mobile',
		'b42s__header_nav__line_height',
		'b42s__header_nav__line_height_medium',
		'b42s__header_nav__line_height_mobile',
		'b42s__header_nav__letter_spacing',
		'b42s__header_nav__letter_spacing_medium',
		'b42s__header_nav__letter_spacing_mobile',
		'b42s__blockquote__font_size',
		'b42s__blockquote__font_size_medium',
		'b42s__blockquote__font_size_mobile',
		'b42s__blockquote__line_height',
		'b42s__blockquote__line_height_medium',
		'b42s__blockquote__line_height_mobile',
		'b42s__blockquote__margin_bottom',
		'b42s__blockquote__margin_bottom_medium',
		'b42s__blockquote__margin_bottom_mobile',
		'fl-nav-font-family',
		'fl-nav-font-weight',
		'fl-nav-font-format',
		'fl-nav-font-size',
		'fl-heading-style',
		'fl-title-font-family',
		'fl-title-font-weight',
		'fl-title-font-format',
		'fl-heading-font-family',
		'fl-heading-font-weight',
		'fl-heading-font-format',
		'fl-h1-font-size',
		'fl-h1-font-size_medium',
		'fl-h1-font-size_mobile',
		'fl-h1-line-height',
		'fl-h1-line-height_medium',
		'fl-h1-line-height_mobile',
		'fl-h1-letter-spacing',
		'fl-h1-letter-spacing_medium',
		'fl-h1-letter-spacing_mobile',
		'fl-h2-font-size',
		'fl-h2-font-size_medium',
		'fl-h2-font-size_mobile',
		'fl-h2-line-height',
		'fl-h2-line-height_medium',
		'fl-h2-line-height_mobile',
		'fl-h2-letter-spacing',
		'fl-h2-letter-spacing_medium',
		'fl-h2-letter-spacing_mobile',
		'b42s__h2__font_weight',
		'b42s__h2__font_format',
		'fl-h3-font-size',
		'fl-h3-font-size_medium',
		'fl-h3-font-size_mobile',
		'fl-h3-line-height',
		'fl-h3-line-height_medium',
		'fl-h3-line-height_mobile',
		'fl-h3-letter-spacing',		
		'fl-h3-letter-spacing_medium',
		'fl-h3-letter-spacing_mobile',
		'b42s__h3__font_weight',
		'b42s__h4__font_format',
		'fl-h4-font-size',
		'fl-h4-font-size_medium',
		'fl-h4-font-size_mobile',
		'fl-h4-line-height',
		'fl-h4-line-height_medium',
		'fl-h4-line-height_mobile',
		'fl-h4-letter-spacing',
		'fl-h4-letter-spacing_medium',
		'fl-h4-letter-spacing_mobile',
		'b42s__h4__font_weight',
		'b42s__h4__font_format',
		'fl-h5-font-size',
		'fl-h5-font-size_medium',
		'fl-h5-font-size_mobile',
		'fl-h5-line-height',
		'fl-h5-line-height_medium',
		'fl-h5-line-height_mobile',
		'fl-h5-letter-spacing',
		'fl-h5-letter-spacing_medium',
		'fl-h5-letter-spacing_mobile',
		'b42s__h5__font_weight',
		'b42s__h5__font_format',
		'fl-h6-font-size',
		'fl-h6-font-size_medium',
		'fl-h6-font-size_mobile',
		'fl-h6-line-height',
		'fl-h6-line-height_medium',
		'fl-h6-line-height_mobile',
		'fl-h6-letter-spacing',
		'fl-h6-letter-spacing_medium',
		'fl-h6-letter-spacing_mobile',
		'b42s__h6__font_weight',
		'b42s__h6__font_format',
		'fl-button-font-family',
		'fl-button-font-weight',
		'fl-button-font-size',
		'fl-button-line-height',
		'fl-button-text-transform',
	);

	/**
	 * Load a translation for this plugin.
	 *
	 * @since 0.1
	 * @return void
	 */
	static public function load_plugin_textdomain()
	{
		load_plugin_textdomain( 'customizer-export-import', false, basename( CEI_PLUGIN_DIR ) . '/lang/' );
	}

	/**
	 * Check to see if we need to do an export or import.
	 * This should be called by the customize_register action.
	 *
	 * @since 0.1
	 * @since 0.3 Passing $wp_customize to the export and import methods.
	 * @param object $wp_customize An instance of WP_Customize_Manager.
	 * @return void
	 */
	static public function init( $wp_customize )
	{
		if ( current_user_can( 'edit_theme_options' ) ) {

			if ( isset( $_REQUEST['cei-export'] ) ) {
				$type = $_REQUEST['cei-export-type'] ?: 'all';
				self::_export( $wp_customize, $type );
			}
			if ( isset( $_REQUEST['cei-import'] ) && isset( $_FILES['cei-import-file'] ) ) {
				self::_import( $wp_customize );
			}
		}
	}

	/**
	 * Prints scripts for the control.
	 *
	 * @since 0.1
	 * @return void
	 */
	static public function controls_print_scripts()
	{
		global $cei_error;

		if ( $cei_error ) {
			echo '<script> alert("' . $cei_error . '"); </script>';
		}
	}

	/**
	 * Enqueues scripts for the control.
	 *
	 * @since 0.1
	 * @return void
	 */
	static public function controls_enqueue_scripts()
	{
		// Register
		wp_register_style( 'cei-css', CEI_PLUGIN_URL . 'css/customizer.css', array(), CEI_VERSION );
		wp_register_script( 'cei-js', CEI_PLUGIN_URL . 'js/customizer.js', array( 'jquery' ), CEI_VERSION, true );

		// Localize
		wp_localize_script( 'cei-js', 'CEIl10n', array(
			'emptyImport'	=> __( 'Please choose a file to import.', 'customizer-export-import' )
		));

		// Config
		wp_localize_script( 'cei-js', 'CEIConfig', array(
			'customizerURL'	  => admin_url( 'customize.php' ),
			'exportNonce'	  => wp_create_nonce( 'cei-exporting' )
		));

		// Enqueue
		wp_enqueue_style( 'cei-css' );
		wp_enqueue_script( 'cei-js' );
	}

	/**
	 * Registers the control with the customizer.
	 *
	 * @since 0.1
	 * @param object $wp_customize An instance of WP_Customize_Manager.
	 * @return void
	 */
	static public function register( $wp_customize )
	{
		require_once CEI_PLUGIN_DIR . 'classes/class-cei-control.php';

		// Add the export/import section.
		$wp_customize->add_section( 'cei-section', array(
			'title'	   => __( 'Export/Import', 'customizer-export-import' ),
			'priority' => 10000000
		));

		// Add the export/import setting.
		$wp_customize->add_setting( 'cei-setting', array(
			'default' => '',
			'type'	  => 'none'
		));

		// Add the export/import control.
		$wp_customize->add_control( new CEI_Control(
			$wp_customize,
			'cei-setting',
			array(
				'section'	=> 'cei-section',
				'priority'	=> 1
			)
		));
	}

	/**
	 * Export customizer settings.
	 *
	 * @since 0.1
	 * @since 0.3 Added $wp_customize param and exporting of options.
	 * @access private
	 * @param object $wp_customize An instance of WP_Customize_Manager.
	 * @return void
	 */
	static private function _export( $wp_customize, $selective_type )
	{
		if ( ! wp_verify_nonce( $_REQUEST['cei-export'], 'cei-exporting' ) ) {
			return;
		}

		$theme		= get_stylesheet();
		$template	= get_template();
		$charset	= get_option( 'blog_charset' );
		$mods		= get_theme_mods();
		$data		= array(
						  'template'  => $template,
						  'mods'	  => $mods ? $mods : array(),
						  'options'	  => array()
					  );
					  
		$select_type = $selective_type ?: 'all';

		// Get options from the Customizer API.
		$settings = $wp_customize->settings();
		
		if( $select_type == 'typography' ){
			
			$data['options']['export-type'] = 'typography';
			
			error_log( print_r( $mods, true ) );
			
			unset( $data['options'] );
			
			/*$typographic_mods = array_filter(
				$mods,
				function ( $key ) use ( $keys_optin__typography ){
					return in_array( $key, $keys_optin__typography);
				},
				ARRAY_FILTER_USE_KEY
			);
			
			
			$data['mods'] = $typographic_mods;*/
			//asdf
			$data['mods'] = array_intersect_key($mods, self::$keys_optin__typography);
			
			
/*
			foreach( $data['mods'] as $mod_key => $mod_value ){
				if( !in_array( $mod_key, self::$keys_optin__typography ) ){
					unset( $data['mods'][$mod_key] );
				}
			}
*/
			
			// Set the download headers (filename).
			header( 'Content-disposition: attachment; filename=' . $theme . '_typography-export.dat' );
			
			
		}else if( $select_type == 'all' ){
			
			$data['options']['export-type'] = 'all';
			
			foreach ( $settings as $key => $setting ) {

				if ( 'option' == $setting->type ) {
	
					// Don't save widget data.
					if ( 'widget_' === substr( strtolower( $key ), 0, 7 ) ) {
						continue;
					}
	
					// Don't save sidebar data.
					if ( 'sidebars_' === substr( strtolower( $key ), 0, 9 ) ) {
						continue;
					}
					
					// Don't save core options.
					if ( in_array( $key, self::$core_options ) ) {
						continue;
					}
	
					$data['options'][ $key ] = $setting->value();
				}
			}
			
			// Plugin developers can specify additional option keys to export.
			$option_keys = apply_filters( 'cei_export_option_keys', array() );
	
			foreach ( $option_keys as $option_key ) {
				$data['options'][ $option_key ] = get_option( $option_key );
			}
	
			if( function_exists( 'wp_get_custom_css_post' ) ) {
				$data['wp_css'] = wp_get_custom_css();
			}
			
			// Set the download headers (filename).
			header( 'Content-disposition: attachment; filename=' . $theme . '_full-export.dat' );
		}

		// Set the download headers (content-type).
		header( 'Content-Type: application/octet-stream; charset=' . $charset );

		// Serialize the export data.
		echo serialize( $data );

		// Start the download.
		die();
	}

	/**
	 * Imports uploaded mods and calls WordPress core customize_save actions so
	 * themes that hook into them can act before mods are saved to the database.
	 *
	 * @since 0.1
	 * @since 0.3 Added $wp_customize param and importing of options.
	 * @access private
	 * @param object $wp_customize An instance of WP_Customize_Manager.
	 * @return void
	 */
	static private function _import( $wp_customize )
	{
		// Make sure we have a valid nonce.
		if ( ! wp_verify_nonce( $_REQUEST['cei-import'], 'cei-importing' ) ) {
			return;
		}

		// Make sure WordPress upload support is loaded.
		if ( ! function_exists( 'wp_handle_upload' ) ) {
			require_once( ABSPATH . 'wp-admin/includes/file.php' );
		}

		// Load the export/import option class.
		require_once CEI_PLUGIN_DIR . 'classes/class-cei-option.php';

		// Setup global vars.
		global $wp_customize;
		global $cei_error;

		// Setup internal vars.
		$cei_error	 = false;
		$template	 = get_template();
		$overrides   = array( 'test_form' => false, 'test_type' => false, 'mimes' => array('dat' => 'text/plain') );
		$file        = wp_handle_upload( $_FILES['cei-import-file'], $overrides );

		// Make sure we have an uploaded file.
		if ( isset( $file['error'] ) ) {
			$cei_error = $file['error'];
			return;
		}
		if ( ! file_exists( $file['file'] ) ) {
			$cei_error = __( 'Error importing settings! Please try again.', 'customizer-export-import' );
			return;
		}

		// Get the upload data.
		$raw  = file_get_contents( $file['file'] );
		$data = @unserialize( $raw );

		// Remove the uploaded file.
		unlink( $file['file'] );

		// Data checks.
		if ( 'array' != gettype( $data ) ) {
			$cei_error = __( 'Error importing settings! Please check that you uploaded a customizer export file.', 'customizer-export-import' );
			return;
		}
		if ( ! isset( $data['template'] ) || ! isset( $data['mods'] ) ) {
			$cei_error = __( 'Error importing settings! Please check that you uploaded a customizer export file.', 'customizer-export-import' );
			return;
		}
		if ( $data['template'] != $template ) {
			$cei_error = __( 'Error importing settings! The settings you uploaded are not for the current theme.', 'customizer-export-import' );
			return;
		}

		// Import images.
		if ( isset( $_REQUEST['cei-import-images'] ) ) {
			$data['mods'] = self::_import_images( $data['mods'] );
		}

		// Import custom options.
		if ( isset( $data['options'] ) ) {

			foreach ( $data['options'] as $option_key => $option_value ) {

				$option = new CEI_Option( $wp_customize, $option_key, array(
					'default'		=> '',
					'type'			=> 'option',
					'capability'	=> 'edit_theme_options'
				) );

				$option->import( $option_value );
			}
		}

		// If wp_css is set then import it.
		if( function_exists( 'wp_update_custom_css_post' ) && isset( $data['wp_css'] ) && '' !== $data['wp_css'] ) {
			wp_update_custom_css_post( $data['wp_css'] );
		}

		// Call the customize_save action.
		do_action( 'customize_save', $wp_customize );

		// Loop through the mods.
		foreach ( $data['mods'] as $key => $val ) {

			// Call the customize_save_ dynamic action.
			do_action( 'customize_save_' . $key, $wp_customize );

			// Save the mod.
			set_theme_mod( $key, $val );
		}

		// Call the customize_save_after action.
		do_action( 'customize_save_after', $wp_customize );
	}

	/**
	 * Imports images for settings saved as mods.
	 *
	 * @since 0.1
	 * @access private
	 * @param array $mods An array of customizer mods.
	 * @return array The mods array with any new import data.
	 */
	static private function _import_images( $mods )
	{
		foreach ( $mods as $key => $val ) {

			if ( self::_is_image_url( $val ) ) {

				$data = self::_sideload_image( $val );

				if ( ! is_wp_error( $data ) ) {

					$mods[ $key ] = $data->url;

					// Handle header image controls.
					if ( isset( $mods[ $key . '_data' ] ) ) {
						$mods[ $key . '_data' ] = $data;
						update_post_meta( $data->attachment_id, '_wp_attachment_is_custom_header', get_stylesheet() );
					}
				}
			}
		}

		return $mods;
	}

	/**
	 * Taken from the core media_sideload_image function and
	 * modified to return an array of data instead of html.
	 *
	 * @since 0.1
	 * @access private
	 * @param string $file The image file path.
	 * @return array An array of image data.
	 */
	static private function _sideload_image( $file )
	{
		$data = new stdClass();

		if ( ! function_exists( 'media_handle_sideload' ) ) {
			require_once( ABSPATH . 'wp-admin/includes/media.php' );
			require_once( ABSPATH . 'wp-admin/includes/file.php' );
			require_once( ABSPATH . 'wp-admin/includes/image.php' );
		}
		if ( ! empty( $file ) ) {

			// Set variables for storage, fix file filename for query strings.
			preg_match( '/[^\?]+\.(jpe?g|jpe|gif|png)\b/i', $file, $matches );
			$file_array = array();
			$file_array['name'] = basename( $matches[0] );

			// Download file to temp location.
			$file_array['tmp_name'] = download_url( $file );

			// If error storing temporarily, return the error.
			if ( is_wp_error( $file_array['tmp_name'] ) ) {
				return $file_array['tmp_name'];
			}

			// Do the validation and storage stuff.
			$id = media_handle_sideload( $file_array, 0 );

			// If error storing permanently, unlink.
			if ( is_wp_error( $id ) ) {
				@unlink( $file_array['tmp_name'] );
				return $id;
			}

			// Build the object to return.
			$meta					= wp_get_attachment_metadata( $id );
			$data->attachment_id	= $id;
			$data->url				= wp_get_attachment_url( $id );
			$data->thumbnail_url	= wp_get_attachment_thumb_url( $id );
			$data->height			= $meta['height'];
			$data->width			= $meta['width'];
		}

		return $data;
	}

	/**
	 * Checks to see whether a string is an image url or not.
	 *
	 * @since 0.1
	 * @access private
	 * @param string $string The string to check.
	 * @return bool Whether the string is an image url or not.
	 */
	static private function _is_image_url( $string = '' )
	{
		if ( is_string( $string ) ) {

			if ( preg_match( '/\.(jpg|jpeg|png|gif)/i', $string ) ) {
				return true;
			}
		}

		return false;
	}
}
