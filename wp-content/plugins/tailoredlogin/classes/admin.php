<?php
if ( !class_exists( 'pluginbuddy_tailoredlogin_admin' ) ) {
	class pluginbuddy_tailoredlogin_admin {
		
		function pluginbuddy_tailoredlogin_admin( &$parent ) {
			$this->_parent = &$parent;
			$this->_var = &$parent->_var;
			$this->_name = &$parent->_name;
			$this->_options = &$parent->_options;
			$this->_pluginPath = &$parent->_pluginPath;
			$this->_pluginURL = &$parent->_pluginURL;
			$this->_selfLink = &$parent->_selfLink;
			
			add_action( 'admin_menu', array( &$this, 'admin_menu' ) ); // Add menu in admin.
			add_action( 'wp_ajax_handle_attachment', array( &$this, 'handle_ajax_attachment' ) );
			add_action( 'media_view_strings', array( $this, 'add_media_gallery_strings' ) );
		}
		
		// Gets image id on upload to instantly show new image
 		function handle_ajax_attachment() {
            $attachment_data = maybe_unserialize( stripslashes( $_POST['image'] ) );

            if ( is_array( $attachment_data ) ) {
                $imagedata = wp_get_attachment_image_src( $attachment_data['attachment_id'], 'full' );
            } else {
                $attachment_data = json_decode( $attachment_data );
                $imagedata = wp_get_attachment_image_src( $attachment_data[0]->attachment_id, 'full' );
            }       

            die( $imagedata[0] );
		}
		
		function alert() {
			$args = func_get_args();
			return call_user_func_array( array( $this->_parent, 'alert' ), $args );
		}
		
		function video() {
			$args = func_get_args();
			return call_user_func_array( array( $this->_parent, 'video' ), $args );
		}
		
		function tip() {
			$args = func_get_args();
			return call_user_func_array( array( $this->_parent, 'tip' ), $args );
		}
		
		function log() {
			$args = func_get_args();
			return call_user_func_array( array( $this->_parent, 'log' ), $args );
		}
		
		
		function title( $title ) {
			echo '<h2><img src="' . $this->_pluginURL .'/images/icon.png" style="vertical-align: -7px;"> ' . $title . '</h2>';
		}
		
		
		function nonce() {
			wp_nonce_field( $this->_parent->_var . '-nonce' );
		}
		
		
		/**
		 *	savesettings()
		 *	
		 *	Saves a form into the _options array.
		 *	
		 *	Use savepoint to set the root array key path. Accepts variable depth, dividing array keys with pound signs.
		 *	Ex:	$_POST['savepoint'] value something like array_key_name#subkey
		 *		<input type="hidden" name="savepoint" value="files#exclusions" /> to set the root to be $this->_options['files']['exclusions']
		 *		
		 *	All inputs with the name beginning with pound will act as the array keys to be set in the _options with the associated posted value.
		 *	Ex:	$_POST['#key_name'] or $_POST['#key_name#subarray_key_name'] value is the array value to set.
		 *		<input type="text" name="#name" /> will save to $this->_options['name']
		 *		<input type="text" name="#group#17#name" /> will save to $this->_options['groups'][17]['name']
		 */
		function savesettings() {
			check_admin_referer( $this->_parent->_var . '-nonce' );
			
			if ( !empty( $_POST['savepoint'] ) ) {
				$savepoint_root = stripslashes( $_POST['savepoint'] ) . '#';
			} else {
				$savepoint_root = '';
			}
			
			$posted = stripslashes_deep( $_POST ); // Unescape all the stuff WordPress escaped. Sigh @ WordPress for being like PHP magic quotes.
			foreach( $posted as $index => $item ) {
				if ( substr( $index, 0, 1 ) == '#' ) {
					$savepoint_subsection = &$this->_options;
					$savepoint_levels = explode( '#', $savepoint_root . substr( $index, 1 ) );
					foreach ( $savepoint_levels as $savepoint_level ) {
						$savepoint_subsection = &$savepoint_subsection{$savepoint_level};
					}
					$savepoint_subsection = $item;
				}
			}
			
			$this->_parent->save();
			$this->alert( 'Settings saved...' );
		}
		
		
		function admin_scripts() {
			//wp_enqueue_script( 'jquery' );
			wp_enqueue_script( 'pluginbuddy-tooltip-js', $this->_parent->_pluginURL . '/js/tooltip.js' );
			wp_print_scripts( 'pluginbuddy-tooltip-js' );
			wp_enqueue_script( 'pluginbuddy-'.$this->_var.'-admin-js', $this->_parent->_pluginURL . '/js/admin.js' );
			wp_print_scripts( 'pluginbuddy-'.$this->_var.'-admin-js' );
			//custom media uploader scripts
			global $wp_scripts;
			if ( !in_array( 'thickbox', $wp_scripts->done ) ) {
				wp_enqueue_script( 'thickbox' );
				wp_print_scripts( 'thickbox' );
				wp_print_styles( 'thickbox' );
			}
			echo '<link rel="stylesheet" href="'.$this->_pluginURL . '/css/admin.css" type="text/css" media="all" />';
		}
		
		
		/**
		 *	get_feed()
		 *
		 *	Gets an RSS or other feed and inserts it as a list of links...
		 *
		 *	$feed		string		URL to the feed.
		 *	$limit		integer		Number of items to retrieve.
		 *	$append		string		HTML to include in the list. Should usually be <li> items including the <li> code.
		 *	$replace	string		String to replace in every title returned. ie twitter includes your own username at the beginning of each line.
		 *	$cache_time	int			Amount of time to cache the feed, in seconds.
		 */
		function get_feed( $feed, $limit, $append = '', $replace = '', $cache_time = 300 ) {
			require_once(ABSPATH.WPINC.'/feed.php');  
			$rss = fetch_feed( $feed );
			if (!is_wp_error( $rss ) ) {
				$maxitems = $rss->get_item_quantity( $limit ); // Limit 
				$rss_items = $rss->get_items(0, $maxitems); 
				
				echo '<ul class="pluginbuddy-nodecor">';

				$feed_html = get_transient( md5( $feed ) );
				if ( $feed_html == '' ) {
					foreach ( (array) $rss_items as $item ) {
						$feed_html .= '<li>- <a href="' . $item->get_permalink() . '">';
						$title =  $item->get_title(); //, ENT_NOQUOTES, 'UTF-8');
						if ( $replace != '' ) {
							$title = str_replace( $replace, '', $title );
						}
						if ( strlen( $title ) < 30 ) {
							$feed_html .= $title;
						} else {
							$feed_html .= substr( $title, 0, 32 ) . ' ...';
						}
						$feed_html .= '</a></li>';
					}
					set_transient( md5( $feed ), $feed_html, $cache_time ); // expires in 300secs aka 5min
				}
				echo $feed_html;
				
				echo $append;
				echo '</ul>';
			} else {
				echo 'Temporarily unable to load feed...';
			}
		}
		
		
		function view_gettingstarted() {
			require( 'view_gettingstarted.php' );
		}
		
		
		function view_settings() {
			require( 'view_settings.php' );
		}
		
		
		/** admin_menu()
		 *
		 * Initialize menu for admin section.
		 *
		 */		
		function admin_menu() {
			if ( isset( $this->_parent->_series ) && ( $this->_parent->_series != '' ) ) {
				// Handle series menu. Create series menu if it does not exist.
				global $menu;
				$found_series = false;
				foreach ( $menu as $menus => $item ) {
					if ( $item[0] == $this->_parent->_series ) {
						$found_series = true;
					}
				}
				
				if ( $found_series === false ) {
					add_menu_page( $this->_parent->_series . ' Getting Started', $this->_parent->_series, 'administrator', 'pluginbuddy-' . strtolower( $this->_parent->_series ), array(&$this, 'view_gettingstarted'), $this->_parent->_pluginURL.'/images/pluginbuddy.png' );
					add_submenu_page( 'pluginbuddy-' . strtolower( $this->_parent->_series ), $this->_parent->_name.' Getting Started', 'Getting Started', 'administrator', 'pluginbuddy-' . strtolower( $this->_parent->_series ), array(&$this, 'view_gettingstarted') );
				}
				// Register for getting started page
				global $pluginbuddy_series;
				if ( !isset( $pluginbuddy_series[ $this->_parent->_series ] ) ) {
					$pluginbuddy_series[ $this->_parent->_series ] = array();
				}
				$pluginbuddy_series[ $this->_parent->_series ][ $this->_parent->_name ] = $this->_pluginPath;
				
				add_submenu_page( 'pluginbuddy-' . strtolower( $this->_parent->_series ), $this->_parent->_name, $this->_parent->_name, 'administrator', $this->_parent->_var.'-settings', array(&$this, 'view_settings'));
			} else { // NOT IN A SERIES!
				// Add main menu (default when clicking top of menu)
				add_menu_page($this->_parent->_name.' Getting Started', $this->_parent->_name, 'administrator', $this->_parent->_var, array(&$this, 'view_gettingstarted'), $this->_parent->_pluginURL.'/images/tailoredlogin-menuicon2.png');
				// Add sub-menu items (first should match default page above)
				add_submenu_page( $this->_parent->_var, $this->_parent->_name.' Getting Started', 'Getting Started', 'administrator', $this->_parent->_var, array(&$this, 'view_gettingstarted'));
				add_submenu_page( $this->_parent->_var, $this->_parent->_name.' Style Manager', 'Style Manager', 'administrator', $this->_parent->_var.'-settings', array(&$this, 'view_settings'));
			}
		}

        /** 
         * This adds IT_Media_Library strings
         *
        */
        function add_media_gallery_strings( $strings ) { 
            $strings['itMediaLibraryAddImageTitle'] = __( 'Add an Image', 'it-l10n-tailoredlogin' );
            $strings['setITMediaLibraryAddImage']   = __( 'Add image', 'it-l10n-tailoredlogin' );
            return $strings;
        }   

		
	} // End class
	
	$pluginbuddy_tailoredlogin_admin = new pluginbuddy_tailoredlogin_admin( $this );
}
