<?php
/**
 * Sandbox test file
 *
 * @package     n8finch
 * @since       1.0.0
 * @author      finchps
 * @link        https://knowthecode.io
 * @license     GNU General Public License 2.0+
 */
//namespace n8finch;

/**
 * @internal    never define functions inside callbacks.
 *              these functions could be run multiple times; this would result in a fatal error.
 */

/**
 * Provides default values for the Input Options.
 */
function wporg_default_options() {

	$defaults = array(
		'wporg_field_activate'    => '',
		'wporg_field_radio' => '',
		'wporg_field_checkbox_option1' => '',
		'wporg_field_checkbox_option2' => '',
		'wporg_field_text' => '',

	);

	return apply_filters( 'wporg_default_options', $defaults );

} // end yass_theme_default_input_options

/**
 * custom option and settings
 */
function wporg_settings_init() {

	if ( false == get_option( 'wporg_options' ) ) {
		add_option( 'wporg_options', apply_filters( 'wporg_default_options', wporg_default_options() ) );
	} // end if


	// register a new setting for "wporg" page
	register_setting( 'wporg', 'wporg_options' );

	// register a new section in the "wporg" page
	add_settings_section(
		'wporg_section_developers',
		__( 'The Matrix has you.', 'wporg' ),
		'wporg_section_developers_cb',
		'wporg'
	);

	// register a new field in the "wporg_section_developers" section, inside the "wporg" page


	add_settings_field(
		'wporg_field_activate', // as of WP 4.6 this value is used only internally
		// use $args' label_for to populate the id inside the callback
		__( 'Activate?', 'wporg' ),
		'wporg_field_active_cb',
		'wporg',
		'wporg_section_developers',
		[
			'label_for'         => 'wporg_field_activate',
			'class'             => 'wporg_row',
			'wporg_custom_data' => 'activate-yass-plugin',
		]
	);

	add_settings_field(
		'wporg_field_radio', // as of WP 4.6 this value is used only internally
		// use $args' label_for to populate the id inside the callback
		__( 'Activate?', 'wporg' ),
		'wporg_field_radio_cb',
		'wporg',
		'wporg_section_developers',
		[
			'label_for'         => 'wporg_field_radio',
			'class'             => 'wporg_row',
			'wporg_custom_data' => 'radio-yass-plugin',
		]
	);

	add_settings_field(
		'wporg_field_checkbox', // as of WP 4.6 this value is used only internally
		// use $args' label_for to populate the id inside the callback
		__( 'Activate?', 'wporg' ),
		'wporg_field_checkbox_cb',
		'wporg',
		'wporg_section_developers',
		[
			'label_for'         => 'wporg_field_checkbox',
			'class'             => 'wporg_row',
			'wporg_custom_data' => 'checkbox-yass-plugin',
		]
	);

	add_settings_field(
		'wporg_field_text', // as of WP 4.6 this value is used only internally
		// use $args' label_for to populate the id inside the callback
		__( 'Activate?', 'wporg' ),
		'wporg_field_text_cb',
		'wporg',
		'wporg_section_developers',
		[
			'label_for'         => 'wporg_field_text',
			'class'             => 'wporg_row',
			'wporg_custom_data' => 'text-yass-plugin',
		]
	);
}

/**
 * register our wporg_settings_init to the admin_init action hook
 */
add_action( 'admin_init', 'wporg_settings_init' );

/**
 * custom option and settings:
 * callback functions
 */

// developers section cb

// section callbacks can accept an $args parameter, which is an array.
// $args have the following keys defined: title, id, callback.
// the values are defined at the add_settings_section() function.
function wporg_section_developers_cb( $args ) {
	?>
	<p id="<?= esc_attr( $args['id'] ); ?>"><?= esc_html__( 'Follow the white rabbit.', 'wporg' ); ?></p>
	<?php
}

// pill field cb

// field callbacks can accept an $args parameter, which is an array.
// $args is defined at the add_settings_field() function.
// wordpress has magic interaction with the following keys: label_for, class.
// the "label_for" key value is used for the "for" attribute of the <label>.
// the "class" key value is used for the "class" attribute of the <tr> containing the field.
// you can add custom key value pairs to be used inside your callbacks.


function wporg_field_active_cb( $args ) {
	// get the value of the setting we've registered with register_setting()
	$options = get_option( 'wporg_options' );
	// output the field
	?>
	<select id="<?= esc_attr( $args['label_for'] ); ?>"
	        data-custom="<?= esc_attr( $args['wporg_custom_data'] ); ?>"
	        name="wporg_options[<?= esc_attr( $args['label_for'] ); ?>]"
	>
		<option
			value="activate" <?= isset( $options[ $args['label_for'] ] ) ? ( selected( $options[ $args['label_for'] ], 'activate', false ) ) : ( '' ); ?>>
			<?= esc_html( 'activate', 'wporg' ); ?>
		</option>
		<option
			value="deactivate" <?= isset( $options[ $args['label_for'] ] ) ? ( selected( $options[ $args['label_for'] ], 'deactivate', false ) ) : ( '' ); ?>>
			<?= esc_html( 'deactivate', 'wporg' ); ?>
		</option>
	</select>

	<?php
}

function wporg_field_radio_cb( $args ) {
	// get the value of the setting we've registered with register_setting()
	$options = get_option( 'wporg_options' );
	// output the field

	d('before', $options);

	if( array_key_exists( 'wporg_field_radio', $options) ) {
		$is_checked = $options['wporg_field_radio'];
	} else {
		$is_checked = '';
	}



	?>

	<input type="radio" id="<?= esc_attr( $args['label_for'] . 'option1' ); ?>"
	       data-custom="<?= esc_attr( $args['wporg_custom_data'] ); ?>"
	       name="wporg_options[<?= esc_attr( $args['label_for'] ); ?>]"
	       value="1" <?php checked( 1, $is_checked, true ); ?>/>

	<label for="wporg_options[<?= esc_attr( $args['label_for'] . 'option1' ); ?>]"><?= esc_html( 'Option 1', 'wporg' ); ?></label>

	<input type="radio" id="<?= esc_attr( $args['label_for'] . 'option2' ); ?>"
	       data-custom="<?= esc_attr( $args['wporg_custom_data'] ); ?>"
	       name="wporg_options[<?= esc_attr( $args['label_for'] ); ?>]"
	       value="2" <?php checked( 2, $is_checked, true ); ?>/>

	<label for="wporg_options[<?= esc_attr( $args['label_for'] . 'option2' ); ?>]"><?= esc_html( 'Option 2', 'wporg' ); ?></label>

	<?php
}


function wporg_field_checkbox_cb( $args ) {
	// get the value of the setting we've registered with register_setting()
	$options = get_option( 'wporg_options' );
	// output the field

	d('before', $options);

	if( array_key_exists( 'wporg_field_checkbox_option1', $options) ) {
		$is_checked_1 = $options['wporg_field_checkbox_option1'];
	} else {
		$is_checked_1 = '';
	}

	if( array_key_exists( 'wporg_field_checkbox_option2', $options) ) {
		$is_checked_2 = $options['wporg_field_checkbox_option2'];
	} else {
		$is_checked_2 = '';
	}



	?>

	<input type="checkbox" id="<?= esc_attr( $args['label_for'] . '_option1' ); ?>"
	       data-custom="<?= esc_attr( $args['wporg_custom_data'] ); ?>"
	       name="wporg_options[<?= esc_attr( $args['label_for'] . '_option1' ); ?>]"
	       value="1" <?php checked( 1, $is_checked_1, true ); ?>/>

	<label for="wporg_options[<?= esc_attr( $args['label_for'] . '_option1' ); ?>]"><?= esc_html( 'Option 1', 'wporg' ); ?></label>

	<input type="checkbox" id="<?= esc_attr( $args['label_for'] . '_option2' ); ?>"
	       data-custom="<?= esc_attr( $args['wporg_custom_data'] ); ?>"
	       name="wporg_options[<?= esc_attr( $args['label_for'] . '_option2' ); ?>]"
	       value="2" <?php checked( 2, $is_checked_2, true ); ?>/>

	<label for="wporg_options[<?= esc_attr( $args['label_for'] . '_option2' ); ?>]"><?= esc_html( 'Option 2', 'wporg' ); ?></label>

	<?php
}


function wporg_field_text_cb( $args ) {
	// get the value of the setting we've registered with register_setting()
	$options = get_option( 'wporg_options' );
	// output the field

	d('before', $options);

	if( array_key_exists( 'wporg_field_text', $options) ) {
		$is_checked = $options['wporg_field_text'];
	} else {
		$is_checked = '';
	}

	?>

	<input type="text" id="<?= esc_attr( $args['label_for'] ); ?>"
	       data-custom="<?= esc_attr( $args['wporg_custom_data'] ); ?>"
	       name="wporg_options[<?= esc_attr( $args['label_for'] ); ?>]"
	       value="<?php echo $is_checked; ?>"/>

	<label for="wporg_options[<?= esc_attr( $args['label_for'] ); ?>]"><?= esc_html( 'Label', 'wporg' ); ?></label>


	<?php
}




/**
 * top level menu
 */
function wporg_options_page() {
	// add top level menu page
	add_menu_page(
		'WPOrg',
		'WPOrg Options',
		'manage_options',
		'wporg',
		'wporg_options_page_html'
	);
}

/**
 * register our wporg_options_page to the admin_menu action hook
 */
add_action( 'admin_menu', 'wporg_options_page' );

/**
 * top level menu:
 * callback functions
 */
function wporg_options_page_html() {
	// check user capabilities
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}

	// add error/update messages

	// check if the user have submitted the settings
	// wordpress will add the "settings-updated" $_GET parameter to the url
	if ( isset( $_GET['settings-updated'] ) ) {
		// add settings saved message with the class of "updated"
		add_settings_error( 'wporg_messages', 'wporg_message', __( 'Settings Saved', 'wporg' ), 'updated' );
	}

	// show error/update messages
	settings_errors( 'wporg_messages' );
	?>
	<div class="wrap">
		<h1><?= esc_html( get_admin_page_title() ); ?></h1>
		<form action="options.php" method="post">
			<?php
			// output security fields for the registered setting "wporg"
			settings_fields( 'wporg' );
			// output setting sections and their fields
			// (sections are registered for "wporg", each field is registered to a specific section)
			do_settings_sections( 'wporg' );
			// output save settings button
			submit_button( 'Save Settings' );
			?>
		</form>
	</div>
	<?php
}


