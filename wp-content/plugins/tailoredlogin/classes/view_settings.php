<?php
$this->_parent->load();
$this->admin_scripts();

if ( !empty( $_POST['save'] ) ) {
	$this->savesettings();
}
?>
<div class="wrap">
	<?php $this->title( 'Style Manager' ); ?>
	The styles below will allow you to customize your <a href="<?php echo home_url() . '/wp-login.php'; ?>">WordPress login page</a>.
	<?php
	// Call style manager class
		require_once( $this->_parent->_pluginPath . '/lib/styleman/styleman.php' );
		$wp_upload_dir = WP_UPLOAD_DIR();
		$style_definitions_file = $this->_parent->_pluginPath . '/style_definitions.txt';
		$style_file = $this->_parent->_pluginPath . '/style_defaults.css';
		$custom_style_file = $wp_upload_dir['basedir'] . '/tailoredlogin/style_custom.css';
		// Definitions text file, default styling css file, custom styling css file for overriding, variable to set true or false to on whether to include custom styling
		$pbstyles->styleman( $style_definitions_file, $style_file, $custom_style_file, $this->_options['customstyles_enabled'] );
	?>
</div>
