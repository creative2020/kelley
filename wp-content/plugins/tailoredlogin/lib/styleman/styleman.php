<?php
/*
 * iThemes.com
 * Created: June 10, 2010
 * Updated: May 25, 2011
 * Iteration: 3
 *
 */

if (!class_exists("PluginBuddy_styleman")) {
	class PluginBuddy_styleman {
		function PluginBuddy_styleman(&$parent) {
			$this->_parent = &$parent;
			if ( !isset( $this->_parent->_var ) ) {
				$this->_parent->_var = $this->_parent->_parent->_var;
				$this->_parent->_selfLink = $this->_parent->_parent->_selfLink;
				$this->_parent->_pluginURL = $this->_parent->_parent->_pluginURL;
				$this->_parent->_pluginPath = $this->_parent->_parent->_pluginPath;
			}
		}
		
		function styleman( $style_definitions_file, $style_file, $custom_style_file, &$enabled_var ) {
			//error_reporting(E_ALL ^ E_NOTICE);
		
			wp_enqueue_script( 'jpicker', $this->_parent->_pluginURL . '/js/jpicker.js' );
			wp_print_scripts( 'jpicker' );
		
			// Media upload script
			if ( !wp_script_is( 'media-upload' ) ) {
				wp_enqueue_script( 'media-upload' );
				wp_print_scripts( 'media-upload' );
			}

			// Add WP 3.5 Media Library dependants
			if ( ! $this->_parent->_parent->_medialibrary->_pre_wp_3_5_compatibility ) { 
				wp_enqueue_media();
				wp_enqueue_script( 'it-medialibrary-add-image', $this->_parent->_pluginURL . '/lib/medialibrary/medialibrary.js' );
			}

			echo '<link rel="stylesheet" href="'.$this->_parent->_pluginURL . '/css/jpicker.css" type="text/css" media="all" />';	
			echo '<script type="text/javascript">';
			echo 	'jQuery(document).ready(function() {';
			echo 		"jQuery('.jpicker').jPicker( { window: { expandable: true, alphaSupport: false, effects: { type: 'fade' } }, images : {  clientPath: '" . $this->_parent->_pluginURL . "/images/' } });";
			echo 	'});';
			echo '</script>';
			?>
		
			<script type="text/javascript">
				var pb_button_value;
			
				jQuery(document).ready(function() {
					jQuery('.pb_customlogin_button').click(function(e) {
						pb_button_value = jQuery(this).attr('rel');
					});
					// Remove custom background image
					jQuery('.pb_customremove_button').click(function(e) {
						pb_remove_value = jQuery(this).attr('rel');
						jQuery( '#backimgpreview' + pb_remove_value ).css( 'background-image', '' );
						jQuery( '#pb_attachment_url' + pb_remove_value ).val( '' );
						jQuery( '#pb_attachment_data' + pb_remove_value ).val( '' );
					});
					
					// Show preview of background image settings
					jQuery( "#backimgpreview1" ).css( 'background-position', jQuery( 'select[name$="background-position"]:first' ).val() );
					jQuery( "#backimgpreview1" ).css( 'background-repeat', jQuery( 'select[name$="background-repeat"]:first' ).val() );
					jQuery( "#backimgpreview2" ).css( 'background-position', jQuery( 'select[name$="background-position"]:last' ).val() );
					jQuery( "#backimgpreview2" ).css( 'background-repeat', jQuery( 'select[name$="background-repeat"]:last' ).val() );
					
					// Show preview of background image changes
					jQuery('select[name$="background-position"]:first').bind( 'change', function() {
						jQuery( "#backimgpreview1" ).css( 'background-position', jQuery( this ).val() )
					} );
					jQuery('select[name$="background-repeat"]:first').bind( 'change', function() {
						jQuery( "#backimgpreview1" ).css( 'background-repeat', jQuery( this ).val() )
					} );
					jQuery('select[name$="background-position"]:last').bind( 'change', function() {
						jQuery( "#backimgpreview2" ).css( 'background-position', jQuery( this ).val() )
					} );
					jQuery('select[name$="background-repeat"]:last').bind( 'change', function() {
						jQuery( "#backimgpreview2" ).css( 'background-repeat', jQuery( this ).val() )
					} );
				
				});
				// Insert custom image values into hidden and show preview
				function pb_medialibrary( $response ) {
					jQuery('#pb_attachment_data' + pb_button_value ).val( $response );
					jQuery.post( ajaxurl, { action : 'handle_attachment', 'image' : $response }, function(results){
						if ( results ){
							jQuery( '#backimgpreview' + pb_button_value ).css( 'background-image', 'url("' + results + '")');
							jQuery( '#pb_attachment_url' + pb_button_value ).val( results );
						}
					} );
				
				}
			</script>
			
			<?php
		
			if ( isset( $_POST['disable_customstyles'] ) ) {
				$enabled_var = false;
				if ( is_callable( $this->_parent, 'save' ) ) { // Call save in parent if its callable there.  In case we are two classes in, we will need to go up two levels.
					$this->_parent->save();
				} else {
					$this->_parent->_parent->save();
				}
				$this->_showStatusMessage( 'Custom styles disabled.' );
			}
			if ( isset( $_POST['enable_customstyles'] ) ) {
				$enabled_var = true;
				if ( is_callable( $this->_parent, 'save' ) ) { // Call save in parent if its callable there.  In case we are two classes in, we will need to go up two levels.
					$this->_parent->save();
				} else {
					$this->_parent->_parent->save();
				}
				$this->_showStatusMessage( 'Custom styles enabled.' );
			}
		
			if ( isset( $_POST['save_styles'] ) ) {
				//echo '<pre>';
				$last_select = '';
				$block_top = '';
				$block_inner = '';
				$final_css = '';
				foreach ( $_POST as $line_key => $line ) {
					
					$line_key = str_replace( '_', '.', $line_key );
					$line_key = urldecode( $line_key );
					if ( strstr( $line_key, ',' ) ) {
						$selector = explode( ',', $line_key );
						if ( $selector[0] != $last_select ) {
							if ( $last_select != '' ) {
								if ( $block_inner != '' ) { // Only print this selector if it has stuff inside its block.
									$final_css .= $block_top;
									$final_css .= $block_inner;
									$final_css .= "}\r\n\r\n";
								}
								$block_top = '';
								$block_inner = '';
							}
							$block_top .= str_replace( '_', ' ', $selector[0]) . ' {' . "\r\n";
							$last_select = $selector[0];
						}
						if ( $line != '' ) {
							$block_inner .= "\t" . $selector[1] . ': ';
							if ( ( ( $selector[1] == 'color' ) || ( $selector[1] == 'background' ) || ( $selector[1] == 'background-color' ) || ( $selector[1] == 'border-color' ) ) && ( substr($line, 0, 1) != '#' ) ) {
								$block_inner .= '#';
							}
							if ( ( $selector[1] == 'background-image' ) ) {
								$line = 'url("' . $line . '")';
							}
							if ( ( $selector[1] == 'width' ) ) {
								if ( !is_numeric( $line ) ) {
									$line = '282';
								}
								$line = $line . 'px';
							}
							//Add !important values for WP 3.2 login screen
							switch( $line_key ) {
								case 'html,background-image':
								case 'html,background-position':
								case 'html,background-repeat':
								case 'html,background-attachment':
								case 'html,background-color':
									$line .= ' !important';
									break;
								case '.login #nav a,color':
									$line .= ' !important';
									break;
								case '.login #backtoblog a,color':
									$line .= ' !important';
									break;
								case 'p#backtoblog,background':
									global $wp_version;
									if ( version_compare( $wp_version, '3.2', '>=' ) ) {
										$line = 'none';
									}
									break;
							}
							$block_inner .= $line . ";\r\n";
							
							// if #loginform input.button-primary background is set also set border-color
							if ( ( $selector[0] == '#loginform input.button-primary' ) && ( $selector[1] == 'background' ) ) {
								$block_inner .= "\tborder-color:#" . $line . ";\r\n";
							}
						}
					}
				}
				//echo "}\n";
				//echo '</pre>';
			
				// Add the last item
				$final_css .= $block_top;
				$final_css .= $block_inner;
				$final_css .= "}\r\n\r\n";
			
				//echo $final_css;
			
				if ( !file_exists( dirname( $custom_style_file ) ) ) {
					// mkdir( dir, permissions, recursive_boolean );
					@mkdir( dirname( $custom_style_file ), 0755, true ) or die( 'Error #3489721. Cannot create directory to write custom style file Check permissions: ' . dirname( $custom_style_file ) );
				}
				$fh = @fopen( $custom_style_file, 'w' ) or die( 'Error #6545443443. Cannot write to custom style file Check permissions: ' . $custom_style_file );
				fwrite($fh, $final_css);
				fclose($fh);
			
				//Set background image values
				if ( !empty( $_POST['backimg1'] ) ) {
					if ( is_numeric( $_POST['backimg1'] ) ) {
						$this->_parent->_options['backimgmain'] = $_POST['backimg1'];
					} else {
						if ( is_serialized( $_POST['backimg1'] ) ) {
							$attachment_data1 = unserialize( stripslashes( $_POST['backimg1'] ) );
							$this->_parent->_options['backimgmain'] = $attachment_data1['attachment_id'];
						} else {
							$attachment_data1 = json_decode( stripslashes( $_POST['backimg1'] ) );
							$this->_parent->_options['backimgmain'] = $attachment_data1[0]->attachment_id;
						}
					}
				} else {
					$this->_parent->_options['backimgmain'] = '';
				}
				if ( !empty( $_POST['backimg2'] ) ) {
					if ( is_numeric( $_POST['backimg2'] ) ) {
						$this->_parent->_options['backimghead'] = $_POST['backimg2'];
					} else {
						if ( is_serialized( $_POST['backimg2'] ) ) {
							$attachment_data2 = unserialize( stripslashes( $_POST['backimg2'] ) );
							$this->_parent->_options['backimghead'] = $attachment_data2['attachment_id'];
						} else {
							$attachment_data2 = json_decode( stripslashes( $_POST['backimg2'] ) );
							$this->_parent->_options['backimghead'] = $attachment_data2[0]->attachment_id;
						}
					}
				} else {
					$this->_parent->_options['backimghead'] = '';
				}
			
				//Set custom header url
				if ( !empty( $_POST['pbheadurl'] ) ) {
					$this->_parent->_options['pbheadurl'] = esc_url( $_POST['pbheadurl'] );
				} else {
					$this->_parent->_options['pbheadurl'] = get_site_url();
				}
			
				$enabled_var = true;
				if ( is_callable( $this->_parent, 'save' ) ) { // Call save in parent if its callable there.  In case we are two classes in, we will need to go up two levels.
					$this->_parent->save();
				} else {
					$this->_parent->_parent->save();
				}
				$loginpage = home_url() . '/wp-login.php';
				$this->_showStatusMessage( 'Your styles have been saved. View your <a href="' . $loginpage . '">WordPress login page</a>.' );

			}
		
			//echo $style_definitions_file;
			if ( !file_exists( $style_definitions_file ) ) {
				echo '<td colspan="2">ALERT! Style Manager is unavailable for this plugin. Ask the developer to create a style_definitions.txt file.</td>';
			} else {
				?>
				<form method="post" action="<?php echo $this->_parent->_selfLink; ?>-settings">
					<table class="form-table">
						<tr>
							<td colspan="2">
								<?php
									if ( isset( $_GET['developer'] ) ) {
										echo '<h3>Plugin Settings:</h3><pre>';
										print_r( $this->_parent->_options );
										echo '</pre>';
									}
								
									$css = $this->get_css( $style_file ); // Get style.css styles
								
									if ( file_exists( $custom_style_file ) ) {
										$custom_css = $this->get_css( $custom_style_file ); // Get custom styles
										
										
										//$custom_css = str_replace( '!important', '', $custom_css );
										foreach ( $custom_css as $area => &$rules ) {
											foreach ( $rules as &$rule ) {
												$rule = str_replace( ' !important', '', $rule );
											}
										}
										
										if ( is_array( $custom_css ) ) {
											$css = array_merge( $css, $custom_css ); // Merge custom over the normal styles
										}
									}
								
								
									if ( isset( $_GET['developer'] ) ) {
										echo '<h3>CSS:</h3><pre>';
										print_r( $css );
										echo '</pre>';
									}
								
									$style_file = explode("\n", file_get_contents( $style_definitions_file ) );
									$imginstance = '';
									foreach ( (array) $style_file as $item ) {
										//if ( (substr($item, 0, 2) != '//') && ($item != '') ) { // Ignore commented and blank lines.
										if ( strstr( $item, ',' ) ) {
						
											$item = explode( ",", $item );
										
											echo '<tr>';
												if ( $item[0] == '-' ) {
													echo '<td colspan="2"><b>' . $item[1] . '</b></td>';
												} elseif ( $item[0] == '-tip' ) {
													echo '<td colspan="2"><b>';
													echo $item[1];
													echo $this->_parent->_parent->tip( "<img src='" . $this->_parent->_pluginURL . "/images/screenshots/" . $item[2] . "' alt='" . $item[1] . "' />" );
													echo '</b></td>';
												} elseif ( $item[1] == 'font-size' ) {
													echo '<td>' . $item[2] . '</td>';
													echo '<td>' . $this->style_pixel_size( $item, $css ) . '</td>';
												} elseif ( $item[1] == 'background-size' ) {
													echo '<td>' . $item[2];
													$this->_parent->_parent->tip('This controls the background size of the header logo. Enter in the format shown here: Ex. 310px 70px. Note this is a css3 feature.');
													echo '</td>';
													echo '<td>' . $this->style_background_size( $item, $css ) . '</td>';
												} elseif ( $item[1] == 'width' ) {
													echo '<td>' . $item[2] . '</td>';
													echo '<td>' . $this->style_width( $item, $css ) . '</td>';
												} elseif ( $item[1] == 'font-family' ) {
													$options = Array(
														'Default(Lucida Grande)'=>	'"Lucida Grande",Verdana,Arial,"Bitstream Vera Sans",sans-serif',
														'Arial'			=>	'Arial, Helvetica, sans-serif',
														'Helvetica'		=>	'Helvetica, sans-serif',					
														'Georgia'		=>	'Georgia, Serif',
														'Verdana'		=>	'Verdana, Geneva, sans-serif',
														'Times New Roman'	=>	'‘Times New Roman’, Times, serif',
														'Tahoma'		=>	'Tahoma, Geneva, sans-serif',
														'Impact'		=>	'Impact, Charcoal, sans-serif'
													);
													echo '<td>' . $item[2] . '</td>';
													echo '<td>' . $this->style_select( $item, $css, $options ) . '</td>';
												} elseif ( ( $item[1] == 'color' ) || ( $item[1] == 'background-color' ) || ( $item[1] == 'background' ) ) {
													echo '<td>' . $item[2] . '</td>';
													echo '<td>' . $this->style_color( $item, $css ) . '</td>';
												} elseif ( $item[1] == 'background-image' ) {
													$imginstance++;
														if ( $imginstance == '1' ) {
															$imgid = $this->_parent->_options['backimgmain'];
														} else {
															$imgid = $this->_parent->_options['backimghead'];
														}
													echo '<td class="bg-imgprev-label">' . $item[2] . '</td>';
													echo '<td>' . $this->style_background_image( $item, $css, $imginstance, $imgid ) . '</td>';
												} elseif ( $item[1] == 'background-position' ) {
													$options = Array(
														'left top (Default)'	=>	'left top',
														'left center'		=>	'left center',
														'left bottom'		=>	'left bottom',
														'right top'		=>	'right top',
														'right center'		=>	'right center',
														'right bottom'		=>	'right bottom',
														'center top'		=>	'center top',
														'center center'		=>	'center',
														'center bottom'		=>	'center bottom',
													);
													echo '<td>' . $item[2] . '</td>';
													echo '<td>' . $this->style_select( $item, $css, $options ) . '</td>';
												} elseif ( $item[1] == 'background-repeat' ) {
													$options = Array(
														'no-repeat (Default)'	=>	'no-repeat',
														'tile'			=>	'repeat',
														'tile horizontally'	=>	'repeat-x',
														'tile vertically'	=>	'repeat-y'
													);
													echo '<td>' . $item[2] . '</td>';
													echo '<td>' . $this->style_select( $item, $css, $options ) . '</td>';
												} elseif ( $item[1] == 'background-attachment' ) {
													$options = Array(
														'scroll (Default)'	=>	'scroll',
														'fixed'			=>	'fixed'
													);
													echo '<td>' . $item[2] . '</td>';
													echo '<td>' . $this->style_select( $item, $css, $options ) . '</td>';
												} elseif ( $item[1] == 'custom-header' ) {
													echo '<td>' . $item[2] . '</td>';
													if ( $this->_parent->_options['pbheadurl'] !== 'http://wordpress.org' ) {
														$url = $this->_parent->_options['pbheadurl'];
													} else {
														$url = 'http://wordpress.org';
													}
													echo '<td><input type="text" name="pbheadurl" size="38" maxlength="108" value="' . $url . '"/></td>';
												}
											echo '</tr>';
										}
									}
									unset($style_file);
								?>
							</td>
						</tr>
					</table>
					<p class="submit"><input value="Save Styles" type="submit" name="save_styles" class="button-primary" id="save_styles" /></p>
					<?php
						//$this->_addUsedInputs();
						wp_nonce_field( $this->_parent->_var . '-nonce' );
					?>
				</form>
				<br /><br />
			<?php
		
			}
		}
	
		// Stylesheet functions
		function style_color( $item, $css ) {
			$return = '';
			$return .= '<input type="text" name="' . urlencode( $item[0] . ',' . $item[1] ) . '" value="';
			if ( isset( $css[$item[0]][$item[1]] ) ) {
				if ( $css[$item[0]][$item[1]] !== 'transparent' ) {
					$return .= $css[$item[0]][$item[1]];
				}
			}
			$return .= '" class="jpicker" />';
			//$return .= '<span class="jpicker"></span>';
			return $return;
		}
		function style_background_size($item, $css) { 
			if (isset( $css[$item[0]][$item[1]] ) ) {
				$size_val = $css[$item[0]][$item[1]];
			} else {
				$size_val = '';
			}
			$return = '<input type="text" name="' . urlencode($item[0] . ',' . $item[1]) . '" value="' . $size_val . '" style="text-align: right" size="10"/>';
			return $return; 
		}
		// $negative_values		boolean		Set to true to allow for zero and negative values to be generated.
		function style_pixel_size( $item, $css, $negative_values = false ) {
			$return = '';

			$pixelsizes[0] = '';
			if ( $negative_values === true ) {
				$c = -21;
			} else {
				$c = 0;
			}

			while ( $c <= 45 ) {
				$c++;
				$pixelsizes[$c] = $c . 'px';
			}
			$return .= '<select name="' . urlencode($item[0] . ',' . $item[1]) . '">';

			foreach ( $pixelsizes as $pixelsize ) {
				$return .= '<option value="' . $pixelsize . '"';
				if ( isset( $css[$item[0]][$item[1]] ) ) {
					$return .= selected(  str_replace( '"', '', $css[$item[0]][$item[1]]),  $pixelsize , false );
				}

				$return .= '>' . $pixelsize . '</option>';
			}
			$return .= '</select>';

			return $return;
		}
		function style_width( $item, $css ) {
			if ( isset( $css[$item[0]][$item[1]] ) ) {
				$widval = str_replace( 'px', '', $css[$item[0]][$item[1]] );
			} else {
				$widval = '';
			}
			$return = '<input type="text" name="' . urlencode($item[0] . ',' . $item[1]) . '" value="' . $widval . '" size="6" style="text-align: right"/>px';
			return $return;
		}
		function style_background_image( $item, $css, $imginstance, $imgid ) {
			$link_args = array(
				'text' => __( 'Add Custom Image', 'it-l10n-tailoredlogin' ),
				'classes' => 'button button-secondary pb_customlogin_button',
				'id' => 'addimgbutton' . $imginstance,
				'rel' => $imginstance,
			);
			$return = '';
			if ( $imgid !== '' ) {
				$fullimg = wp_get_attachment_image_src( $imgid, 'full' );
				$imgurl = $fullimg[0];
				$imgprev = 'style="background-image: url(' . $imgurl . ');" ';
			} else {
				$imgurl = '';
				$imgprev = '';
			}
		
			if ( $imginstance == '2' ) {
				$return .= 'Suggested 310x70 pixels';
			}
			$return .= '<div id="backimgpreview' . $imginstance . '"' . $imgprev . '></div>';
			$return .= '<p class="actions">';
			$return .= $this->_parent->_parent->_medialibrary->get_add_link( $link_args );
			$return .=	'<a id="removeimgbutton' . $imginstance . '" class="button button-secondary pb_customremove_button" rel="' . $imginstance . '">Remove Image</a>';
			$return .= '</p>';
			$return .= '<input type="hidden" name="backimg' . $imginstance . '" id="pb_attachment_data' . $imginstance . '" value="' . $imgid . '" />';
			$return .= '<input type="hidden" name="' . urlencode($item[0] . ',' . $item[1]) . '" id="pb_attachment_url' . $imginstance . '" value="' . $imgurl . '" />';
		
			return $return;
		}
		function style_select( $item, $css, $options ) {
			$return = '';
			$return .= '<select name="' . urlencode($item[0] . ',' . $item[1]) . '">';
			foreach ( $options as $optkey => $optval ) {
				$return .= '<option value="' . $optval . '"';
				if ( isset( $css[$item[0]][$item[1]] ) && ( str_replace( '"', '', $css[$item[0]][$item[1]]) == $optval ) ) {
					$return .= ' selected="selected"';
				}
				$return .= '>' . $optkey . '</option>';
			}
			$return .= '</select>';

			return $return;
		}
		// End stylesheet functions									
	
		// Reads a CSS file and puts it into an array.  Key is the selector path and value is the contents.
		function get_css( $style_file ) {
			$style_file = file_get_contents( $style_file );

			$style_file = preg_replace('/(\/\*[\s\S]*?\*\/)/', '', $style_file); 

			//echo $style_file;

			$style_lines = explode("\n", $style_file );


			$cssstyles = '';
			foreach ($style_lines as $line_num => $line) {
				$cssstyles .= trim($line);
			}
			$tok = strtok($cssstyles, "{}"); // remove brackets. p{color:#000000;} -> p color:#000000;
			$sarray = array();
			$spos = 0;
			while ($tok !== false) { //separating selectors from styles and store those values in the $sarray
				$sarray[$spos] = $tok;
				$spos++; 
				$tok = strtok("{}");
			}
			$size = count($sarray);
			$selectors = array();
			$sstyles = array();

			$npos = 0;
			$sstl = 0;

			for($i = 0; $i<$size; $i++){ // separate styles from selectors
				if ($i % 2 == 0) {
					$selectors[$npos] = trim( $sarray[$i] );
					$npos++;
				} else {
					$sstyles[$sstl] = trim( $sarray[$i] );
					$sstl++;
				}
			}

			foreach ($selectors as $selector => $selector_val) {

				$css[$selector_val] = Array();
				$styles = explode(';', $sstyles[$selector]); // Put all the styling for this selector in an array.
			
				foreach ($styles as $style) { // Loop through array to assign each to their own array index for easy access.
					if ( $style != '' ) {
						$style_pair = explode(':', $style );
						$css[$selector_val][ $style_pair[0] ] = trim( $style_pair[1] );
					}
				}
			}
		
			if ( empty ( $css ) ) { $css = ''; }
			return $css;
		}
			
		function _showStatusMessage( $message ) {
			echo '<div id="message" class="updated fade"><p><strong>'.$message.'</strong></p></div>';			
		}
		function _showErrorMessage( $message ) {
			echo '<div id="message" class="error"><p><strong>'.$message.'</strong></p></div>';
		}
	} // End class
	$pbstyles = new PluginBuddy_styleman( $this );
}
?>
