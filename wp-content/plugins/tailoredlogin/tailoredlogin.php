<?php
/**
 *
 * Plugin Name: Tailored Login
 * Plugin URI: http://ithemes.com/purchase/tailored-login/
 * Description: Easily customize login screen styles.
 * Version: 1.0.28
 * Author: iThemes.com
 * Author URI: http://ithemes.com/
 * iThemes Package: tailoredlogin
 *
 * Installation:
 *
 * 1. Download and unzip the latest release zip file.
 * 2. If you use the WordPress plugin uploader to install this plugin skip to step 4.
 * 3. Upload the entire plugin directory to your `/wp-content/plugins/` directory.
 * 4. Activate the plugin through the 'Plugins' menu in WordPress Administration.
 *
 * Usage:
 *
 * 1. Navigate to the new plugin menu in the Wordpress Administration Panel.
 * 2. Enter the plugin settings page.
 * 3. Make and save style settings.
 * 4. View wp-login.php to see results.
 *
 */


if ( !class_exists( 'pluginbuddy_tailoredlogin' ) ) {
	class pluginbuddy_tailoredlogin {
		// DEPRECATED VARS; use plugin_info():
		var $_wp_minimum = '3.2.1';
		var $_url = 'http://pluginbuddy.com/purchase/tailoredlogin/';	// DEPRECATED v0.3.7. Use $this->plugin_info( 'url' ) to get plugin url. Update this url until obsolete.
		var $_var = 'pluginbuddy_tailoredlogin';			// DEPRECATED v0.3.10. Use $this->_slug. Match _var and _slug until removal.
		
		var $_slug = 'pluginbuddy_tailoredlogin';			// Format: pluginbuddy_pluginnamehere. All lowecase, no dashes.
		var $_name = 'Tailored Login';					// Pretty plugin name. Only used for display so any format is valid.
		var $_series = '';						// Series name if applicable.
		var $_timestamp = 'M j, Y, g:iA';				// PHP timestamp format.
		var $_defaults = array(
			'backimgmain'		=>	'',
			'backimghead'		=>	'',
			'pbheadurl'		=>	'http://wordpress.org',
			'customstyles_enabled'	=>	true,
		);
		
		// Default constructor. This is automatically run on each page load.
		function pluginbuddy_tailoredlogin() {
			$this->_pluginPath = dirname( __FILE__ );
			$this->_pluginRelativePath = ltrim( str_replace( '\\', '/', str_replace( rtrim( ABSPATH, '\\\/' ), '', $this->_pluginPath ) ), '\\\/' );
			$this->_pluginURL = site_url() . '/' . $this->_pluginRelativePath;
			$this->_wp_upload_dir = WP_UPLOAD_DIR();
			
			if ( isset( $_SERVER['HTTPS'] ) && $_SERVER['HTTPS'] == 'on' ) { $this->_pluginURL = str_replace( 'http://', 'https://', $this->_pluginURL ); }
			$selflinkvar = explode( '?', $_SERVER['REQUEST_URI'] );
			$this->_selfLink = array_shift( $selflinkvar ) . '?page=' . $this->_var;
			
			// register custom login widgets
			add_action( 'widgets_init', array( &$this, 'tailoredlogin_reg_widgets' ) );
			
			if ( is_admin() ) { // Runs when in the admin dashboard.
				require_once( $this->_pluginPath . '/lib/medialibrary/load.php' );
				add_action( 'init', array( &$this, 'init_medialibrary' ) );
				require_once( $this->_pluginPath . '/classes/admin.php' );
				register_activation_hook( __FILE__, array( &$this, 'activate' ) ); // Run some code when plugin is activated in dashboard.
				add_filter( 'plugin_row_meta', array( &$this, 'filter_plugin_row_meta' ), 10, 2 );
			} else { // Runs when in non-dashboard parts of the site.
				add_action( 'login_head', array( &$this, 'tailoredlogin_styles' ) );
				add_filter('login_headerurl', array( &$this, 'switch_headerlink' ) );
				add_action( 'login_head', array( &$this, 'tailoredlogin_widget_top' ) );
				add_action( 'login_footer', array( &$this, 'tailoredlogin_widget_bottom' ) );
			}
		}

		/**
		 * Initialize the IT_Media_Library
		*/
		function init_medialibrary() {
			global $wp_version;

			// Check for Wordpress Version for media library. 
			if ( version_compare( $wp_version, $this->_wp_minimum, '<=' ) ) {
				$media_lib_version =  array(
						'select_button_text'			=>			'Select this Image',
						'tabs'					=>			array( 'pb_uploader' => 'Upload Images to Media Library', 'library' => 'Select from Media Library' ),
						'show_input-image_alt_text'		=>			false,
						'show_input-url'			=>			false,
						'show_input-image_align'		=>			false,
						'show_input-image_size'			=>			false,
						'show_input-description'		=>			true,
						'custom_help-caption'			=>			'Overlaying text to be displayed if captions are enabled.',
						'custom_help-description'		=>			'Optional URL for this image to link to.',
						'custom_label-description'		=>			'Link URL',
						'use_textarea-caption'			=>			true,
						'use_textarea-description'		=>			false,
					);
			}
		
			else { 
				$media_lib_version =  array(
						'select_button_text'			=>			'Select this Image',
						'tabs'					=>			array( 'type' => 'Upload Images to Media Library', 'library' => 'Select from Media Library' ),
						'show_input-image_alt_text'		=>			false,
						'show_input-url'			=>			false,
						'show_input-image_align'		=>			false,
						'show_input-image_size'			=>			false,
						'show_input-description'		=>			true,
						'custom_help-caption'			=>			'Overlaying text to be displayed if captions are enabled.',
						'custom_help-description'		=>			'Optional URL for this image to link to.',
						'custom_label-description'		=>			'Link URL',
						'use_textarea-caption'			=>			true,
						'use_textarea-description'		=>			false,
					);
			}
			$this->_medialibrary = new IT_Media_Library( $this, $media_lib_version );
		}
		
		//Filter visit plugin site link on plugins page
		function filter_plugin_row_meta( $plugin_meta, $plugin_file ) {
			if ( strstr( $plugin_file, strtolower( $this->_name ) ) ) {
				$plugin_meta[2] = '<a title="Visit plugin site" href="http://ithemes.com/">Visit iThemes.com</a>';
				return $plugin_meta;
			} else {
				return $plugin_meta;
			}
		}
		
		// Set custom header url
		function switch_headerlink() {
			$this->load();
			$url = $this->_options['pbheadurl'];
			return $url;
		}
		
		// Add styles
		function tailoredlogin_styles() {
			echo '<link rel="stylesheet" type="text/css" href="' . $this->_pluginURL . '/style_defaults.css" />';
			echo '<link rel="stylesheet" type="text/css" href="' . $this->_wp_upload_dir['baseurl'] . '/tailoredlogin/style_custom.css" />';
		}
		
		// Register tailoredlogin widget areas
		function tailoredlogin_reg_widgets() {
			if ( function_exists('register_sidebar') ) {
				$widgets = array( 'top' => 'Top', 'bottom' => 'Bottom' );
				foreach ( $widgets as $wid => $wname ) {
					register_sidebar( array(
						'id'		=> 'pb-tailoredlogin-' . $wid,
						'name'		=> $this->_name . ' ' . $wname,
						'description'	=> $wname . ' widget area for the Custom login screen.',
						'before_widget'	=> '<div class="pb-tailoredlogin-widget">',
						'after_widget'	=> '</div>',
						'before_title'	=> '<h4>',
						'after_title'	=> '</h4>',
					));
				}
			}
		}
		
		// add top widget area to login page
		function tailoredlogin_widget_top() {
			$this->tailoredlogin_widget('top');
		}
		// add bottom widget area to login page
		function tailoredlogin_widget_bottom() {
			$this->tailoredlogin_widget('bottom');
		}

		// add widget area to login page
		function tailoredlogin_widget($area) {
			if ( is_active_sidebar( 'pb-tailoredlogin-' . $area ) ) {
				echo '<div id="pb-tailoredlogin-sidebar-' . $area . '" class="pb-tailoredlogin-sidebar">';
					dynamic_sidebar( 'pb-tailoredlogin-' . $area );
				echo '</div>';
			}
		}
		
		
		// name, title, description, author, authoruri, version, pluginuri OR url, textdomain, domainpath, network
		function plugin_info( $type ) {
			if ( empty( $this->_info ) ) {
				require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
				$this->_info = array_change_key_case( get_plugin_data( __FILE__, false, false ), CASE_LOWER );
				$this->_info['url'] = $this->_info['pluginuri'];
			}
			
			if ( !empty( $this->_info[$type] ) ) {
				return $this->_info[$type];
			} else {
				return 'UNKNOWN_VAR_354-' . $type;
			}
		}
		
		/**
		 *	alert()
		 *
		 *	Displays a message to the user at the top of the page when in the dashboard.
		 *
		 *	$message	string		Message you want to display to the user.
		 *	$error		boolean		OPTIONAL! true indicates this alert is an error and displays as red. Default: false
		 *	$error_code	int		OPTIONAL! Error code number to use in linking in the wiki for easy reference.
		 */
		function alert( $message, $error = false, $error_code = '' ) {
			$log_error = false;
			
			echo '<div id="message" class="';
			if ( $error === false ) {
				echo 'updated fade';
			} else {
				echo 'error';
				$log_error = true;
			}
			if ( $error_code != '' ) {
				$message .= '<p><a href="http://ithemes.com/codex/page/' . $this->_name . ':_Error_Codes#' . $error_code . '" target="_new"><i>' . $this->_name . ' Error Code ' . $error_code . ' - Click for more details.</i></a></p>';
				$log_error = true;
			}
			if ( $log_error === true ) {
				$this->log( $message . ' Error Code: ' . $error_code, 'error' );
			}
			echo '"><p><strong>' . $message . '</strong></p></div>';
		}
		
		
		/**
		 *	tip()
		 *
		 *	Displays a message to the user when they hover over the question mark. Gracefully falls back to normal tooltip.
		 *	HTML is supposed within tooltips.
		 *
		 *	$message	string		Actual message to show to user.
		 *	$title		string		Title of message to show to user. This is displayed at top of tip in bigger letters. Default is blank. (optional)
		 *	$echo_tip	boolean		Whether to echo the tip (default; true), or return the tip (false). (optional)
		 */
		function tip( $message, $title = '', $echo_tip = true ) {
			$tip = ' <a class="pluginbuddy_tip" title="' . $title . ' - ' . $message . '"><img src="' . $this->_pluginURL . '/images/pluginbuddy_tip.png" alt="(?)" /></a>';
			if ( $echo_tip === true ) {
				echo $tip;
			} else {
				return $tip;
			}
		}
		
		/**
		 *	video()
		 *
		 *	Displays a message to the user when they hover over the question mark. Gracefully falls back to normal tooltip.
		 *	HTML is supposed within tooltips.
		 *
		 *	$video_key	string		YouTube video key from the URL ?v=VIDEO_KEY_HERE
		 *	$title		string		Title of message to show to user. This is displayed at top of tip in bigger letters. Default is blank. (optional)
		 *	$echo_tip	boolean		Whether to echo the tip (default; true), or return the tip (false). (optional)
		 */
		function video( $video_key, $title = '', $echo_tip = true ) {
			global $wp_scripts;
			if ( !in_array( 'thickbox', $wp_scripts->done ) ) {
				wp_enqueue_script( 'thickbox' );
				wp_print_scripts( 'thickbox' );
				wp_print_styles( 'thickbox' );
			}
			
			$tip = '<a href="http://www.youtube.com/embed/' . urlencode( $video_key ) . '?autoplay=1&TB_iframe=1&width=640&height=400" class="thickbox pluginbuddy_tip" title="Video Tutorial - ' . $title . '"><img src="' . $this->_pluginURL . '/images/pluginbuddy_play.png" alt="(video)" /></a>';
			if ( $echo_tip === true ) {
				echo $tip;
			} else {
				return $tip;
			}
		}
		
		
		/**
		 *	log()
		 *
		 *	Logs to a text file depending on settings.
		 *	0 = none, 1 = errors only, 2 = errors + warnings, 3 = debugging (all kinds of actions)
		 *
		 *	$text		string		Text to log.
		 *	$log_type	string		Valid options: error, warning, all (default so may be omitted).
		 *
		 */
		function log( $text, $log_type = 'all' ) {
			$write = false;
			
			if ( !isset( $this->_options['log_level'] ) ) {
				$this->load();
			}
			
			if ( $this->_options['log_level'] == 0 ) { // No logging.
				return;
			} elseif ( $this->_options['log_level'] == 1 ) { // Errors only.
				if ( $log_type == 'error' ) {
					$write = true;
				}
			} elseif ( $this->_options['log_level'] == 2 ) { // Errors and warnings only.
				if ( ( $log_type == 'error' ) || ( $log_type == 'warning' ) ) {
					$write = true;
				}
			} elseif ( $this->_options['log_level'] == 3 ) { // Log all; Errors, warnings, actions, notes, etc.
				$write = true;
			}
			
			if ( $write === true ) {
				$fh = fopen( WP_CONTENT_DIR . '/uploads/' . $this->_var . '.txt', 'a');
				fwrite( $fh, '[' . date( $this->_timestamp . ' ' . get_option( 'gmt_offset' ), time() + (get_option( 'gmt_offset' )*3600) ) . '-' . $log_type . '] ' . $text . "\n" );
				fclose( $fh );
			}
		}
		
		function load() {
			$this->_options=get_option($this->_var);
			$options = array_merge( $this->_defaults, (array)$this->_options );
			
			if ( $options !== $this->_options ) {
				// Defaults existed that werent already in the options so we need to update their settings to include some new options.
				$this->_options = $options;
				$this->save();
			}
			
			return true;
		}
		
		function save() {
			add_option( $this->_var, $this->_options, '', 'no' ); // 'No' prevents autoload if we wont always need the data loaded.
			update_option( $this->_var, $this->_options );
			return true;
		}
		
		/**
		 * activate()
		 *
		 * Run on plugin activation. Useful for setting up initial stuff.
		 *
		 */
		function activate() {
		}
	} // End class
	
	$pluginbuddy_tailoredlogin = new pluginbuddy_tailoredlogin();
}


function ithemes_tailoredlogin_updater_register( $updater ) {
	$updater->register( 'tailoredlogin', __FILE__ );
}

add_action( 'ithemes_updater_register', 'ithemes_tailoredlogin_updater_register' );

require( dirname( __FILE__ ) . '/lib/updater/load.php' );
