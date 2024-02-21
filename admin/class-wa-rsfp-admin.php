<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://www.wilhemarnoldy.fr
 * @since      1.0.0
 *
 * @package    Wa_Rsfp
 * @subpackage Wa_Rsfp/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Wa_Rsfp
 * @subpackage Wa_Rsfp/admin
 * @author     Wilhem Arnoldy <contact@wilhemarnoldy.fr>
 */
class Wa_Rsfp_Admin {

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
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Wa_Rsfp_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Wa_Rsfp_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/wa-rsfp-admin.css', array(), $this->version, 'all' );

	}

	// Set different admin styleshoots for different post types
	// -------------------
	//add_action( 'admin_print_styles-edit.php', 'my_admin_edit_styles' );
	//add_action( 'admin_print_styles-post-new.php', 'example_function' ); // Example
	//add_action( 'admin_print_styles-edit-tags.php', 'example_function' ); // Example
	public function enqueue_edit_styles() {
		global $typenow;
		switch ($typenow) {

			case 'directory':
			wp_enqueue_style( 'admin-style-directory', plugins_url('/css/admin-style-directory.css',__FILE__), array(), '1.0' );
			break;

			case 'farm':
			wp_enqueue_style( 'admin-style-farm', plugins_url('/css/admin-style-farm.css',__FILE__), array(), '1.0' );
			break;
	
			case 'structure':
			wp_enqueue_style( 'admin-style-structure', plugins_url('/css/admin-style-structure.css',__FILE__), array(), '1.0' );
			break;

			case 'operation':
			wp_enqueue_style( 'admin-style-operation', plugins_url('/css/admin-style-operation.css',__FILE__), array(), '1.0' );
			break;

			case 'partner':
			wp_enqueue_style( 'admin-style-partner', plugins_url('/css/admin-style-partner.css',__FILE__), array(), '1.0' );
			break;

			}
	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Wa_Rsfp_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Wa_Rsfp_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script(
			$this->plugin_name, 
			plugin_dir_url( __FILE__ ) . 'js/wa-rsfp-admin.js', 
			array( 'jquery' ), 
			$this->version, false
		);
		wp_enqueue_script( 
			$this->plugin_name . '_markdown', 
			plugin_dir_url( __FILE__ ) . 'js/wa-rsfp-markdown.js', 
			array(), 
			$this->version, false
		);

	}

	/**
	 * Register the JavaScript for the editor area.
	 *
	 * @since    1.3.0
	 */
	public function enqueue_editor_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Wa_Rsfp_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Wa_Rsfp_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		
		wp_enqueue_script(
			$this->plugin_name . '_editor',
			plugin_dir_url( __FILE__ ) . '/js/wa-rsfp-editor.js', // Adjust the path to where your JS file is located.
			array( 'wp-blocks', 'wp-dom-ready', 'wp-edit-post' ),
			$this->version, false
		);
	}

	/**
	 * Load the required dependencies for admin.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {
		// Manage admin general functions
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-wa-rsfp-general.php';
		// Adding metabox io custom post type 
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-wa-rsfp-register.php';
		// Adding metabox io custom taxonomy 
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-wa-rsfp-taxonomy.php';
		// Adding metabox io custom fields 
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-wa-rsfp-fields.php';
		// Adding metabox io custom blocks and default blocks 
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-wa-rsfp-blocks.php';
		// Extending metabox io custom fields 
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-wa-rsfp-extend.php';
		// Manage admin columns 
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-wa-rsfp-columns.php';
		// Manage admin filter dropdowns 
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-wa-rsfp-filters.php';
		// Manage admin general notices
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-wa-rsfp-notices.php';
	}

	/**
	 * Run the required dependencies for admin.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function run_dependencies() {
		// After init hooks
		register_post_types();
		register_taxonomies();
		register_custom_meta_fields();
		//add_action( 'rwmb_meta_boxes', 'register_custom_meta_fields', 5);
		add_action( 'rwmb_meta_boxes', 'register_blocks', 5);
	}

	/**
	 * Init plugin
	 *
	 * @since    1.1.0
	 */
	public function init_plugin() {
		$this->load_dependencies();
		$this->run_dependencies();
	}
	
	/**
	 * Init admin
	 *
	 * @since    1.2.0
	 */
	public function init_admin() {
		//$screen = get_current_screen(); //$screen->id
		global $pagenow;

		if ( is_admin() && !in_array( $pagenow, array( 'plugins.php' ) ) && !function_exists('rwmb_meta') ) {
			wp_die('Error : please install Meta Box plugin.');
		}

		if ( is_admin() && !in_array( $pagenow, array( 'plugins.php' ) ) && !function_exists('mb_term_meta_load') ) {
			wp_die('Error : please install Meta Box Term meta plugin.');
		}

		if ( is_admin() && !in_array( $pagenow, array( 'plugins.php' ) ) && !class_exists( 'MB_Text_Limiter' ) ) {
			wp_die('Error : please install Meta Box Text limiter plugin.');
		}
		
	}
	
}
