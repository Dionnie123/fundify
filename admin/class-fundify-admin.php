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
class Fundify_Admin
{

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

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
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct($plugin_name, $version)
	{

		$this->plugin_name = $plugin_name;
		$this->version = $version;
	}




	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles()
	{

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Fundify_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Fundify_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		$ver = rand();



		wp_enqueue_style($this->plugin_name . '-admin',  plugin_dir_url(__DIR__) . 'admin/css/fundify-admin.css', array(), $ver, 'all', 2);
		wp_enqueue_style($this->plugin_name . '-adminx',  plugin_dir_url(__DIR__) . 'dist/assets/css/admin.css ', array(), $ver, 'all', 2);

		wp_enqueue_style('bsx3xx', 'https://raw.githubusercontent.com/elad2412/the-new-css-reset/main/css/reset.css', array(), $ver, 'all');
		wp_enqueue_style('bsx3x', 'https://cdn.jsdelivr.net/npm/fastbootstrap@2.2.0/dist/css/fastbootstrap.min.css', array(), $ver, 'all');
	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */



	public function enqueue_scripts()
	{

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Fundify_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Fundify_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script($this->plugin_name . 'fdf', plugin_dir_url(__FILE__) . 'js/fundify-admin.js', array('jquery'), $this->version, false);

		wp_enqueue_script('bsx3x', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js', array('jquery'), $this->version, true);
	}

	public function register_settings()
	{
		register_setting($this->options_key, $this->options_key);
	}

	public function addPluginAdminMenu()
	{
		//add_menu_page( $page_title, $menu_title, $capability, $menu_slug, $function, $icon_url, $position );
		add_menu_page($this->plugin_name, 'Fundify', 'administrator', $this->plugin_name, array($this, 'displayPluginAdminDashboard'), 'dashicons-chart-area', 26);

		//add_submenu_page( '$parent_slug, $page_title, $menu_title, $capability, $menu_slug, $function );
		add_submenu_page($this->plugin_name, 'Fundify Settings', 'Settings', 'administrator', $this->plugin_name . '-settings', array($this, 'displayPluginAdminSettings'));
	}


	protected $options_key = 'fundify_options';



	public function displayPluginAdminDashboard()
	{
		// check user capabilities
		if (!current_user_can('manage_options')) {
			return;
		}

		//Get the active tab from the $_GET param
		$default_tab = null;
		$tab = isset($_GET['tab']) ? $_GET['tab'] : $default_tab;

?>
		<!-- Our admin page content should all be inside .wrap -->
		<div class="wrap">
			<!-- Print the page title -->
			<h1><?php echo esc_html(get_admin_page_title()); ?></h1>
			<!-- Here are our tabs -->
			<nav class="nav-tab-wrapper">
				<a href="?page=fundify" class="nav-tab <?php if ($tab === null) : ?>nav-tab-active<?php endif; ?>">General</a>
				<a href="?page=fundify&tab=settings" class="nav-tab <?php if ($tab === 'settings') : ?>nav-tab-active<?php endif; ?>">Settings</a>
				<a href="?page=fundify&tab=tools" class="nav-tab <?php if ($tab === 'tools') : ?>nav-tab-active<?php endif; ?>">Tools</a>
			</nav>

			<div class="tab-content">
				<?php switch ($tab):
					case 'settings':
						echo 'Settings'; //Put your HTML here
						break;
					case 'tools':
						echo 'Tools';
						break;
					default:
						echo 'Default tab';
						break;
				endswitch; ?>
			</div>
		</div>
<?php
	}

	public function displayPluginAdminSettings()
	{
		// set this var to be used in the settings-display view
		$active_tab = isset($_GET['tab']) ? $_GET['tab'] : 'general';
		if (isset($_GET['error_message'])) {
			add_action('admin_notices', array($this, 'pluginNameSettingsMessages'));
			do_action('admin_notices', $_GET['error_message']);
		}
		require_once 'partials/' . $this->plugin_name . '-admin-settings-display.php';
	}

	public function pluginNameSettingsMessages($error_message)
	{
		switch ($error_message) {
			case '1':
				$message = __('There was an error adding this setting. Please try again.  If this persists, shoot us an email.', 'my-text-domain');
				$err_code = esc_attr('plugin_name_example_setting');
				$setting_field = 'plugin_name_example_setting';
				break;
		}
		$type = 'error';
		add_settings_error(
			$setting_field,
			$err_code,
			$message,
			$type
		);
	}

	public function registerAndBuildFields()
	{
		/**
		 * First, we add_settings_section. This is necessary since all future settings must belong to one.
		 * Second, add_settings_field
		 * Third, register_setting
		 */
		add_settings_section(
			// ID used to identify this section and with which to register options
			'plugin_name_general_section',
			// Title to be displayed on the administration page
			'',
			// Callback used to render the description of the section
			array($this, 'plugin_name_display_general_account'),
			// Page on which to add this section of options
			'plugin_name_general_settings'
		);
		unset($args);
		$args = array(
			'type'      => 'input',
			'subtype'   => 'text',
			'id'    => 'plugin_name_example_setting',
			'name'      => 'plugin_name_example_setting',
			'required' => 'true',
			'get_options_list' => '',
			'value_type' => 'normal',
			'wp_data' => 'option'
		);
		add_settings_field(
			'plugin_name_example_setting',
			'Example Setting',
			array($this, 'plugin_name_render_settings_field'),
			'plugin_name_general_settings',
			'plugin_name_general_section',
			$args
		);


		register_setting(
			'plugin_name_general_settings',
			'plugin_name_example_setting'
		);
	}

	public function plugin_name_display_general_account()
	{
		echo '<p>These settings apply to all Plugin Name functionality.</p>';
	}

	public function plugin_name_render_settings_field($args)
	{ /* EXAMPLE INPUT
        'type'      => 'input',
        'subtype'   => '',
        'id'    => $this->plugin_name.'_example_setting',
        'name'      => $this->plugin_name.'_example_setting',
        'required' => 'required="required"',
        'get_option_list' => "",
          'value_type' = serialized OR normal,
'wp_data'=>(option or post_meta),
'post_id' =>
*/

		if ($args['wp_data'] == 'option') {
			$wp_data_value = get_option($args['name']);
		} elseif ($args['wp_data'] == 'post_meta') {
			$wp_data_value = get_post_meta($args['post_id'], $args['name'], true);
		}

		switch ($args['type']) {

			case 'input':
				$value = ($args['value_type'] == 'serialized') ? serialize($wp_data_value) : $wp_data_value;
				if ($args['subtype'] != 'checkbox') {
					$prependStart = (isset($args['prepend_value'])) ? '<div class="input-prepend"> <span class="add-on">' . $args['prepend_value'] . '</span>' : '';
					$prependEnd = (isset($args['prepend_value'])) ? '</div>' : '';
					$step = (isset($args['step'])) ? 'step="' . $args['step'] . '"' : '';
					$min = (isset($args['min'])) ? 'min="' . $args['min'] . '"' : '';
					$max = (isset($args['max'])) ? 'max="' . $args['max'] . '"' : '';
					if (isset($args['disabled'])) {
						// hide the actual input bc if it was just a disabled input the informaiton saved in the database would be wrong - bc it would pass empty values and wipe the actual information
						echo $prependStart . '<input type="' . $args['subtype'] . '" id="' . $args['id'] . '_disabled" ' . $step . ' ' . $max . ' ' . $min . ' name="' . $args['name'] . '_disabled" size="40" disabled value="' . esc_attr($value) . '" /><input type="hidden" id="' . $args['id'] . '" ' . $step . ' ' . $max . ' ' . $min . ' name="' . $args['name'] . '" size="40" value="' . esc_attr($value) . '" />' . $prependEnd;
					} else {
						echo $prependStart . '<input type="' . $args['subtype'] . '" id="' . $args['id'] . '" "' . $args['required'] . '" ' . $step . ' ' . $max . ' ' . $min . ' name="' . $args['name'] . '" size="40" value="' . esc_attr($value) . '" />' . $prependEnd;
					}
					/*<input required="required" '.$disabled.' type="number" step="any" id="'.$this->plugin_name.'_cost2" name="'.$this->plugin_name.'_cost2" value="' . esc_attr( $cost ) . '" size="25" /><input type="hidden" id="'.$this->plugin_name.'_cost" step="any" name="'.$this->plugin_name.'_cost" value="' . esc_attr( $cost ) . '" />*/
				} else {
					$checked = ($value) ? 'checked' : '';
					echo '<input type="' . $args['subtype'] . '" id="' . $args['id'] . '" "' . $args['required'] . '" name="' . $args['name'] . '" size="40" value="1" ' . $checked . ' />';
				}
				break;
			default:
				# code...
				break;
		}
	}
}
