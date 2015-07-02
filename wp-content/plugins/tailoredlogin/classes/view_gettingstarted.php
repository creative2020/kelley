<?php
// Needed for fancy boxes...
wp_enqueue_style('dashboard');
wp_print_styles('dashboard');
wp_enqueue_script('dashboard');
wp_print_scripts('dashboard');
// Load scripts and CSS used on this page.
$this->admin_scripts();

// If they clicked the button to reset plugin defaults...
if (!empty($_POST['reset_defaults'])) {
	$this->_options = $this->_parent->_defaults;
	$this->_parent->save();
	$this->_parent->alert( 'Plugin settings have been reset to defaults.' );
}
?>

<div class="wrap">
	<div class="postbox-container" style="width:70%;">
		<?php $this->title( 'Getting Started with ' . $this->_parent->_name . ' v' . $this->_parent->plugin_info( 'version' ) ); ?>
		
		<p>
			<?php echo $this->_parent->_name; ?> will allow you to easily style your 
			<a href="<?php echo home_url() . '/wp-login.php'; ?>">WordPress login page</a>
			 using a custom style manager and two additional widget areas.<br />
			 Here are a few of the style options available in this plugin:
			  <ul>
			  	<li>- Page background image/color</li>
				<li>- Header image/color</li>
				<li>- Header link URL</li>
				<li>- Login form label’s font, size, and text color</li>
				<li>- Login form button’s font, size, text color, and background color</li>
				<li>- Widget & widget bar background colors</li>
				<li>- Widget title background color, font, size, and text color</li>
				<li>- &quot;Back to Blog&quot; bar background color, font, size, and text color</li>
			  </ul>
			  <br />
			  In order to add widgets to your WordPress login page all you need to do is place different widgets
			  into the widget areas added by <?php echo $this->_parent->_name; ?>.
			  <ul style="list-style: disc">
			  	<li>- <?php echo $this->_parent->_name; ?> Top</li>
			  	<li>- <?php echo $this->_parent->_name; ?> Bottom</li>
			  </ul>
		</p>
		
		<br />
		<h3>Version History</h3>
		<textarea rows="7" cols="70"><?php readfile( $this->_parent->_pluginPath . '/history.txt' ); ?></textarea>
		<br /><br />
		<script type="text/javascript">
			jQuery(document).ready(function() {
				jQuery("#pluginbuddy_debugtoggle").click(function() {
					jQuery("#pluginbuddy_debugtoggle_div").slideToggle();
				});
			});
		</script>
		
		<a id="pluginbuddy_debugtoggle" class="button secondary-button">Debugging Information</a>
		<div id="pluginbuddy_debugtoggle_div" style="display: none;">
			<h3>Debugging Information</h3>
			<?php
				$file_data = get_file_data( dirname( dirname( __FILE__ ) ) . '/tailoredlogin.php', array( 'version' => 'Version' ) );
				
				if ( is_array( $file_data ) && isset( $file_data['version'] ) )
					$version = $file_data['version'];
				else
					$version = 'unknown';
				
				echo '<textarea rows="7" cols="65">';
				echo "Plugin Version = {$this->_name} $version ({$this->_parent->_var})\n";
				echo 'WordPress Version = '.get_bloginfo("version")."\n";
				echo 'PHP Version = '.phpversion()."\n";
				global $wpdb;
				echo 'DB Version = '.$wpdb->db_version()."\n";
				echo "\n".serialize($this->_options);
				echo '</textarea>';
			?>
			<p>
			<form method="post" action="<?php echo $this->_selfLink; ?>">
				<input type="hidden" name="reset_defaults" value="true" />
				<input type="submit" name="submit" value="Reset Plugin Settings & Defaults" id="reset_defaults" class="button secondary-button" onclick="if ( !confirm('WARNING: This will reset all settings associated with this plugin to their defaults. Are you sure you want to do this?') ) { return false; }" />
			</form>
			</p>
		</div>
		<br /><br /><br />
		<a href="http://ithemes.com" style="text-decoration: none;"><img src="<?php echo $this->_pluginURL; ?>/images/it-logo.png" style="vertical-align: -3px;" /> iThemes.com</a><br /><br />
	</div>
	<div class="postbox-container" style="width:20%; margin-top: 35px; margin-left: 15px;">
		<div class="metabox-holder">
			<div class="meta-box-sortables">
				
				<div id="breadcrumbslike" class="postbox">
					<div class="handlediv" title="Click to toggle"><br /></div>
					<h3 class="hndle"><span>Things to do...</span></h3>
					<div class="inside">
						<ul class="pluginbuddy-nodecor">
							<li>- <a href="http://twitter.com/home?status=<?php echo urlencode('Check out this awesome plugin, ' . $series . '! http://ithemes.com @ithemes'); ?>" title="Share on Twitter" onClick="window.open(jQuery(this).attr('href'),'ithemes_popup','toolbar=0,status=0,width=820,height=500,scrollbars=1'); return false;">Tweet about this plugin series.</a></li>
							<li>- <a href="http://ithemes.com/find/plugins/">Check out other plugins from iThemes.</a></li>
							<li>- <a href="http://ithemes.com/find/themes/">Check out the themes from iThemes.</a></li>
						</ul>
					</div>
				</div>

				<div id="breadcrumsnews" class="postbox">
					<div class="handlediv" title="Click to toggle"><br /></div>
					<h3 class="hndle"><span>Latest news from iThemes</span></h3>
					<div class="inside">
						<p style="font-weight: bold;">iThemes.com</p>
						<?php $this->get_feed( 'http://ithemes.com/feed/', 5 );  ?>  
						<p style="font-weight: bold;">Twitter @ithemes</p>
						<?php
							$twit_append = '<li>&nbsp;</li>';
							$twit_append .= '<li><img src="'.$this->_pluginURL.'/images/twitter.png" style="vertical-align: -3px;" /> <a href="http://twitter.com/ithemes/">Follow @ithemes on Twitter.</a></li>';
							$twit_append .= '<li><img src="'.$this->_pluginURL.'/images/feed.png" style="vertical-align: -3px;" /> <a href="http://ithemes.com/feed/">Subscribe to RSS news feed.</a></li>';
							$twit_append .= '<li><img src="'.$this->_pluginURL.'/images/email.png" style="vertical-align: -3px;" /> <a href="http://ithemes.com/subscribe/">Subscribe to Email Newsletter.</a></li>';
							$this->get_feed( 'https://api.twitter.com/1/statuses/user_timeline.rss?screen_name=ithemes', 5, $twit_append, 'ithemes: ' );
						?>
					</div>
				</div>
				
				<div id="breadcrumbssupport" class="postbox">
					<div class="handlediv" title="Click to toggle"><br /></div>
					<h3 class="hndle"><span>Need support?</span></h3>
					<div class="inside">
						<p>See our <a href="http://ithemes.com/tutorials/">tutorials & videos</a> or visit our <a href="http://ithemes.com/forum/">support forum</a> for additional information and help.</p>
					</div>
				</div>
				
			</div>
		</div>
	</div>
</div>
