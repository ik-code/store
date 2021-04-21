<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       tatvic.com
 * @since      1.0.0
 *
 * @package    Actionable_Google_Analytics
 * @subpackage Actionable_Google_Analytics/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Actionable_Google_Analytics
 * @subpackage Actionable_Google_Analytics/includes
 * @author     Chiranjiv Pathak <chiranjiv@tatvic.com>
 */
class Actionable_Google_Analytics {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Actionable_Google_Analytics_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		if ( defined( 'PLUGIN_NAME_VERSION' ) ) {
			$this->version = PLUGIN_NAME_VERSION;
		} else {
			$this->version = '3.1';
		}
		$this->plugin_name = 'actionable-google-analytics';
				$this->load_dependencies();
				$this->set_locale();
				$this->define_admin_hooks();
				$this->define_public_hooks();
			add_filter( 'plugin_action_links_' .plugin_basename( plugin_dir_path( __DIR__ ) . $this->plugin_name . '.php' ), array($this,'tvc_plugin_action_links'),10 );
	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Actionable_Google_Analytics_Loader. Orchestrates the hooks of the plugin.
	 * - Actionable_Google_Analytics_i18n. Defines internationalization functionality.
	 * - Actionable_Google_Analytics_Admin. Defines all hooks for the admin area.
	 * - Actionable_Google_Analytics_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-actionable-google-analytics-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-actionable-google-analytics-activator.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-actionable-google-analytics-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-actionable-google-analytics-admin.php';

		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-actionable-google-analytics-settings.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/api/class-actionable-google-analytics-envato-api.php';
		

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */

		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-actionable-google-analytics-public.php';
		$this->loader = new Actionable_Google_Analytics_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Actionable_Google_Analytics_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Actionable_Google_Analytics_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Actionable_Google_Analytics_Admin( $this->get_plugin_name(), $this->get_version() );
		$this->loader->add_action( 'admin_menu', $plugin_admin, 'display_admin_page' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );
		$this->loader->add_action( 'admin_notices', $plugin_admin, 'aga_check_activation_notice' );

	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Actionable_Google_Analytics_Public( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );
		$this->loader->add_action("wp_head", $plugin_public, "add_Analytics_code");
		$this->loader->add_action("wp_footer", $plugin_public, "t_products_impre_clicks");
		$this->loader->add_action("woocommerce_after_shop_loop_item", $plugin_public, "bind_product_metadata");
		$this->loader->add_action("woocommerce_after_single_product", $plugin_public, "product_detail_view");
		$this->loader->add_action("woocommerce_after_cart",$plugin_public, "remove_cart_tracking");
		 //check out step 1,2,3
        $this->loader->add_action("woocommerce_after_checkout_billing_form", $plugin_public, "checkout_step_1_2_tracking");
        $this->loader->add_action("woocommerce_after_checkout_billing_form", $plugin_public, "checkout_step_3_tracking");
        $this->loader->add_action("woocommerce_after_add_to_cart_button", $plugin_public, "add_to_cart");
		
		 //Error 404 Tracking
        $this->loader->add_action("wp_footer", $plugin_public, "error_404_tracking");
		
		//USER ID Tracking
        $this->loader->add_action("wp_footer", $plugin_public, "encode_email_id");
        $this->loader->add_action("wp_footer", $plugin_public, "user_id_tracking");
		
		 //form field analysis
        $this->loader->add_action("woocommerce_after_checkout_form", $plugin_public, "form_field_tracking");
		
		//Internal Promotions
        $this->loader->add_action("wp_footer", $plugin_public, "internal_promotion");

        //Advanced Store data Tracking
        $this->loader->add_action("wp_footer",$plugin_public, "tvc_store_meta_data");
        
        $this->loader->add_action("wp_footer", $plugin_public, "add_google_fb_conversion_tracking");
	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
			add_action('woocommerce_init' , function (){
				$this->loader->run();
			});
		}
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Actionable_Google_Analytics_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}
	
	public function tvc_plugin_action_links($links) {
		if(!empty(unserialize(get_option('aga_purchase_code')))){
			$setting_url = 'admin.php?page=actionable-google-analytics-admin-display';
		}
		else{
			$setting_url = 'admin.php?page=aga-envato-api';
		}
		$doc_link=plugins_url() . '/actionable-google-analytics/documentation/index.html';
		$links[] = '<a href="' . get_admin_url(null, $setting_url) . '">Settings</a>';
		$links[] = '<a href="http://plugins.tatvic.com/actionable-google-analytics-woo-faq/" target="_blank">FAQ</a>';
		$links[] = '<a href="' . $doc_link . '" target="_blank">Documentation</a>';
		return $links;
	}
	

}
