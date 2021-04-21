<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       tatvic.com
 * @since      1.0.0
 *
 * @package    Actionable_Google_Analytics
 * @subpackage Actionable_Google_Analytics/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Actionable_Google_Analytics
 * @subpackage Actionable_Google_Analytics/admin
 * @author     Chiranjiv Pathak <chiranjiv@tatvic.com>
 */
class Actionable_Google_Analytics_Admin {

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
	 * @since      1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	protected $ga_id;
	
	protected $ga_LC;
	
	protected $ga_eeT;
	
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
		$this->ga_eeT  = unserialize(get_option('aga_options'))["ga_eeT"]; 
		$this->ga_id   = unserialize(get_option('aga_options'))['ga_id'];
		if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
			// Put your plugin code here
			add_action('woocommerce_init' , function (){
				$this->ga_LC    = get_woocommerce_currency();
				add_action( 'woocommerce_order_fully_refunded', array($this,'action_woocommerce_order_refunded'),10,2 );
			    add_action( 'woocommerce_order_partially_refunded', array($this,'woocommerce_partial_order_refunded'),10,2 );
			});
		}
	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		$screen = get_current_screen();
		if ( $screen->id == 'toplevel_page_actionable-google-analytics-admin-display' ||
			$screen->id == 'toplevel_page_aga-envato-api'){
			wp_register_style('font_awesome','//use.fontawesome.com/releases/v5.0.13/css/all.css');
            wp_enqueue_style('font_awesome');
			wp_register_style('aga_bootstrap', '//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css');
			wp_enqueue_style('aga_bootstrap');
			wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/actionable-google-analytics-admin.css', array(), $this->version, 'all' );	
		}
		if($screen->id == 'toplevel_page_aga-envato-api'){
			wp_register_style("admin_style", plugin_dir_url( __FILE__ ) . 'css/style.css');
			wp_enqueue_style( "admin_style");	
		}

	}
	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		$screen = get_current_screen();
		if ( $screen->id == 'toplevel_page_actionable-google-analytics-admin-display' ||(isset($_GET['page']) && $_GET['page'] == 'actionable-google-analytics-admin-display')){
			wp_register_script('popper_bootstrap', '//cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js');
			wp_enqueue_script('popper_bootstrap');
			wp_register_script('aga_bootstrap', '//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js');
			wp_enqueue_script('aga_bootstrap');
			wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/actionable-google-analytics-admin.js', array( 'jquery' ), $this->version, false );
		}
		if($screen->id == 'toplevel_page_aga-envato-api'){
			wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/sweetalert.min.js', array( 'jquery' ), $this->version, false );
		}
	}
	
	/**
	 * Display Admin Page.
	 *
	 * @since    1.0.0
	 */
	public function display_admin_page() {
		if(!empty(unserialize(get_option('aga_purchase_code')))){
			add_menu_page(
				'Actionable Google Analytics',
				'Actionable Google Analytics',
				'manage_options',
				'actionable-google-analytics-admin-display',
				array($this, 'showPage'),
				plugin_dir_url(__FILE__) . 'images/tatvic_logo.png',
				26
			);
		}
		else{
			add_menu_page(
				'Actionable Google Analytics',
				'Actionable Google Analytics',
				'manage_options',
				'aga-envato-api',
				array($this, 'call_api'),
				plugin_dir_url(__FILE__) . 'images/tatvic_logo.png',
				26
			);
		}
	}
	public function addAdminPage(){
			add_menu_page(
				'Actionable Google Analytics',
				'Actionable Google Analytics',
				'manage_options',
				'actionable-google-analytics-admin-display',
				array($this, 'showPage'),
				plugin_dir_url(__FILE__) . 'images/tatvic_logo.png',
				26
			);
	
	}
	public function call_api(){
		if(!empty(unserialize(get_option('aga_purchase_code')))){
			$this->showPage();
		}
		else{
			include('partials/aga-envato-api.php');
		}
	}
	
	/**
	 * Generate & return client ID.
	 *
	 * @since    1.0.0
	 */
	public function get_clientId() {
        return (mt_rand(1000000000,9999999999).".".time());
    }
	
	/**
	 * Woo Partial order refund.
	 *
	 * @since    1.0.0
	 */
    public function woocommerce_partial_order_refunded($order_id, $refund_id) {
		if ($this->ga_eeT != "on" ){
            return;
		}
        $order          = wc_get_order( $order_id );
		$refund         = wc_get_order( $refund_id );
		$refunded_items = array();
       
        $query_params = array();
        $i = 1;
        foreach($refund->get_items('line_item') as $item_id=>$item) {
            $query_params["pr{$i}id"] = $item['product_id'];
            $query_params["pr{$i}qt"] = abs($item['qty']);
            $query_params["pr{$i}pr"] = abs($item['total']);
            $i++;
        }
        $param_url = http_build_query( $query_params, '', '&' );
         
        $url   = 'https://www.google-analytics.com/collect?';
        
        $ch = curl_init(); 
        // set url 
        curl_setopt($ch, CURLOPT_URL,$url. "v=1&t=event&ni=1&cu=".$this->ga_LC."&ec=Enhanced-Ecommerce&ea=click&el=partial_refunded&tid=".$this->ga_id."&cid=".$this->get_clientId()."&ti=".$order_id."&pa=refund&".$param_url); 
        
        //return the transfer as a string 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
        
        // $output contains the output string 
        $output = curl_exec($ch); 
        
        // close curl resource to free up system resources 
        curl_close($ch);
        $this->tvc_partial_refund = 1;
        
    }
	
	/**
	 * Woo Full order refund.
	 *
	 * @since    1.0.0
	 */
    public function action_woocommerce_order_refunded($order_id, $refund_id) {
        if ($this->ga_eeT != "on" ||
            get_post_meta($order_id, "tvc_tracked_refund", true) ==1||
            $this->tvc_partial_refund == 1)
            return;
        
        $order          = wc_get_order( $order_id );
		$refund         = wc_get_order( $refund_id );
		$refunded_items = array();
       
        $url   = 'https://www.google-analytics.com/collect?';
        $query = urlencode( '/refundorders/' );
        
        $ch = curl_init(); 
        // set url 
        curl_setopt($ch, CURLOPT_URL,$url. "v=1&t=event&ni=1&cu=".$this->ga_LC."&ec=Enhanced-Ecommerce&ea=click&el=full_refund&tid=".$this->ga_id."&cid=".$this->get_clientId()."&ti=".$order_id."&pa=refund&dp=".$query); 
        
        //return the transfer as a string 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
        
        // $output contains the output string 
        $output = curl_exec($ch); 
        
        // close curl resource to free up system resources 
        curl_close($ch);
        update_post_meta($order_id, "tvc_tracked_refund", 1);
    }
	
	/**
	 * Display Tab page.
	 *
	 * @since    1.0.0
	 */
	public function showPage() {
		require_once( 'partials/actionable-google-analytics-admin-display.php');
		if(!empty($_GET['tab'])){
			$get_action = $_GET['tab'];
		}
		else{
			$get_action = "general_settings";
		}
		if(method_exists($this, $get_action)) {
			$this->$get_action();
		}
	}
	
	public function general_settings() {
		require_once( 'partials/general-fields.php');
	}
	
	public function conversion_tracking() {
		require_once( 'partials/conversion-tracking.php');
	}
	
	public function google_optimize() {
		require_once( 'partials/google-optimize.php');
	}
	
	public function advanced_tracking() {
		require_once( 'partials/advanced-tracking.php');
	}
	public function datastudio_report() {
		require_once( 'partials/datastudio-report.php');
	}
	
	/**
	 * Plugin Activation Notice.
	 *
	 * @since    1.0.0
	 */
	public function aga_check_activation_notice() {
		if( get_transient( 'aga-admin-notice-activation' ) ) {
				if(!empty(unserialize(get_option('aga_purchase_code')))){
					$setting_url = 'admin.php?page=actionable-google-analytics-admin-display';
				}
				else{
					$setting_url = 'admin.php?page=aga-envato-api';
				}
		?>
			<div class="notice notice-warning is-dismissible">
				<p>Due to some major changes, if you are using your GTM with our plugin, please upgrade the Tags in your GTM. (Import the Tags again from <a target="_blank" href="http://plugins.tatvic.com/downloads/woo-plugin-GTM-steps.pdf">our GTM</a>). </p>
		    </div>
			<?php
			delete_transient( 'aga-admin-notice-activation' );
		}
	}

}
