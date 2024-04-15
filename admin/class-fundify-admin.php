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

		wp_enqueue_style($this->fundify . '-admin-dist', plugin_dir_url(__DIR__) . 'dist/assets/css/admin.css', array(), $ver, 'all', 2);
		wp_enqueue_style($this->fundify . '-reset', 'https://raw.githubusercontent.com/elad2412/the-new-css-reset/main/css/reset.css', array(), $ver, 'all');
		wp_enqueue_style($this->fundify . '-bootstrap', 'https://cdn.jsdelivr.net/npm/fastbootstrap@2.2.0/dist/css/fastbootstrap.min.css', array(), $ver, 'all');
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

		wp_enqueue_script($this->fundify . 'admin', plugin_dir_url(__FILE__) . 'js/fundify-admin.js', array('jquery'), $this->version, false);
		wp_enqueue_script($this->fundify . '-admin-dist', plugin_dir_url(__DIR__) . 'dist/assets/js/admin.js', array('jquery'), $this->version, false);
		wp_enqueue_script($this->fundify . '-bootstrap', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js', array('jquery'), $this->version, true);
	}
}
