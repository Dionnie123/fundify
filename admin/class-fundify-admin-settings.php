<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://https://gravatar.com/mbulingit
 * @since      1.0.0
 *
 * @package    Fundify
 * @subpackage Fundify/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Fundify
 * @subpackage Fundify/admin
 * @author     Mark Dionnie <dionnie_bulingit@yahoo.com>
 */
class Fundify_Admin_Settings
{

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $fundify    The ID of this plugin.
	 */
	private $fundify;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $fundify       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct($fundify, $version)
	{

		$this->fundify = $fundify;
		$this->version = $version;
	}

	public function register_settings()
	{
		register_setting($this->options_key, $this->options_key);
	}

	public function add_plugin_admin_menu()
	{
		//add_menu_page( $page_title, $menu_title, $capability, $menu_slug, $function, $icon_url, $position );
		add_menu_page($this->fundify, 'Fundify', 'administrator', $this->fundify, array($this, 'display_plugin_admin_dashboard'), 'dashicons-chart-area', 26);

		//add_submenu_page( '$parent_slug, $page_title, $menu_title, $capability, $menu_slug, $function );
		add_submenu_page($this->fundify, 'Fundify Settings', 'Settings', 'administrator', $this->fundify . '-settings', array($this, 'display_plugin_admin_settings'));
	}


	protected $options_key = 'fundify_options';

	/**
	 * @internal never define functions inside callbacks.
	 * these functions could be run multiple times; this would result in a fatal error.
	 */

	/**
	 * custom option and settings
	 */
	function fundify_settings_init()
	{
		// Register a new setting for "fundify" page.
		register_setting('fundify', 'fundify_options');

		// Register a new section in the "fundify" page.
		add_settings_section(
			'fundify_section_developers',
			__('The Matrix has you.', 'fundify'),
			array($this, 'fundify_section_developers_callback'),
			'fundify'
		);

		// Register a new field in the "fundify_section_developers" section, inside the "fundify" page.
		add_settings_field(
			'fundify_field_pill', // As of WP 4.6 this value is used only internally.
			// Use $args' label_for to populate the id inside the callback.
			__('Pill', 'fundify'),
			array($this, 'fundify_field_pill_cb'),
			'fundify',
			'fundify_section_developers',
			array(
				'label_for'         => 'fundify_field_pill',
				'class'             => 'fundify_row',
				'fundify_custom_data' => 'custom',
			)
		);
	}

	/**
	 * Register our fundify_settings_init to the admin_init action hook.
	 */



	/**
	 * Custom option and settings:
	 *  - callback functions
	 */


	/**
	 * Developers section callback function.
	 *
	 * @param array $args  The settings array, defining title, id, callback.
	 */
	function fundify_section_developers_callback($args)
	{
?>
		<p id="<?php echo esc_attr($args['id']); ?>"><?php esc_html_e('Follow the white rabbit.', 'fundify'); ?></p>
	<?php
	}

	/**
	 * Pill field callbakc function.
	 *
	 * WordPress has magic interaction with the following keys: label_for, class.
	 * - the "label_for" key value is used for the "for" attribute of the <label>.
	 * - the "class" key value is used for the "class" attribute of the <tr> containing the field.
	 * Note: you can add custom key value pairs to be used inside your callbacks.
	 *
	 * @param array $args
	 */
	function fundify_field_pill_cb($args)
	{
		// Get the value of the setting we've registered with register_setting()
		$options = get_option('fundify_options');
	?>
		<select id="<?php echo esc_attr($args['label_for']); ?>" data-custom="<?php echo esc_attr($args['fundify_custom_data']); ?>" name="fundify_options[<?php echo esc_attr($args['label_for']); ?>]">
			<option value="red" <?php echo isset($options[$args['label_for']]) ? (selected($options[$args['label_for']], 'red', false)) : (''); ?>>
				<?php esc_html_e('red pill', 'fundify'); ?>
			</option>
			<option value="blue" <?php echo isset($options[$args['label_for']]) ? (selected($options[$args['label_for']], 'blue', false)) : (''); ?>>
				<?php esc_html_e('blue pill', 'fundify'); ?>
			</option>
		</select>
		<p class="description">
			<?php esc_html_e('You take the blue pill and the story ends. You wake in your bed and you believe whatever you want to believe.', 'fundify'); ?>
		</p>
		<p class="description">
			<?php esc_html_e('You take the red pill and you stay in Wonderland and I show you how deep the rabbit-hole goes.', 'fundify'); ?>
		</p>
	<?php
	}

	/**
	 * Add the top level menu page.
	 */
	function fundify_options_page()
	{


		//add_menu_page( $page_title, $menu_title, $capability, $menu_slug, $function, $icon_url, $position );
		add_menu_page($this->fundify, 'Fundify', 'manage_options', $this->fundify, array($this, 'fundify_options_page_html'), 'dashicons-chart-area', 26);

		//add_submenu_page( '$parent_slug, $page_title, $menu_title, $capability, $menu_slug, $function );
		add_submenu_page($this->fundify, 'Fundify Settings', 'Settings', 'manage_options', $this->fundify . '-settings', array($this, 'fundify_admin_tabs'));
	}


	/**
	 * Register our fundify_options_page to the admin_menu action hook.
	 */



	/**
	 * Top level menu callback function
	 */
	function fundify_options_page_html()
	{
		// check user capabilities
		if (!current_user_can('manage_options')) {
			return;
		}

		// add error/update messages

		// check if the user have submitted the settings
		// WordPress will add the "settings-updated" $_GET parameter to the url
		if (isset($_GET['settings-updated'])) {
			// add settings saved message with the class of "updated"
			add_settings_error('fundify_messages', 'fundify_message', __('Settings Saved', 'fundify'), 'updated');
		}

		// show error/update messages
		settings_errors('fundify_messages');
	?>
		<div class="wrap">
			<h1><?php echo esc_html(get_admin_page_title()); ?></h1>
			<form action="options.php" method="post">
				<?php
				// output security fields for the registered setting "fundify"
				settings_fields('fundify');
				// output setting sections and their fields
				// (sections are registered for "fundify", each field is registered to a specific section)
				do_settings_sections('fundify');
				// output save settings button
				submit_button('Save Settings');
				?>
			</form>
		</div>
<?php
	}

	public function fundify_admin_tabs()
	{
		require_once 'partials/' . $this->fundify . '-admin-tabs.php';
	}
}
