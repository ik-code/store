<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link  tatvic.com
 * @since 1.0.0
 *
 * @packageActionable_Google_Analytics
 * @subpackage Actionable_Google_Analytics/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package Actionable_Google_Analytics
 * @subpackage Actionable_Google_Analytics/public
 * @author Chiranjiv Pathak <chiranjiv@tatvic.com>
 */
class Actionable_Google_Analytics_Public
{

/**
* The ID of this plugin.
*
* @since1.0.0
* @access   private
* @var string $plugin_nameThe ID of this plugin.
*/
private $plugin_name;

/**
* The version of this plugin.
*
* @since1.0.0
* @access   private
* @var string $version The current version of this plugin.
*/
private $version;

/**
* Initialize the class and set its properties.
*
* @since1.0.0
* @param string $plugin_name  The name of the plugin.
* @param string $versionThe version of this plugin.
*/
protected $ga_id;

protected $ga_optimize;

protected $ga_optimize_data;

protected $ga_CG;

protected $ga_CGInd;

protected $ga_IPA;

protected $ga_RTkn;

protected $ga_cID;

protected $ga_eGTM;

protected $ga_PrivacyPolicy;

protected $ga_optimize_delay;

protected $ga_hide_snippet;

protected $ga_UID;

protected $ga_InPromo;

protected $ga_InPromoData;

protected $ga_FF;

protected $ga_eeT;

protected $ga_DF;

protected $ga_404ET;

protected $ga_OPTOUT;

protected $ga_adwords;

protected $ga_adwords_data;

protected $ga_adwords_label;

protected $fb_pixel;

protected $fb_pixel_data;

protected $t_purchase_code;

public $tvc_trans_cookie_arr;

public function __construct($plugin_name, $version)
{

   $this->plugin_name = $plugin_name;
   $this->version = $version;
   $_SESSION['t_npcnt'] = 0;
   $_SESSION['t_fpcnt'] = 0;
   $this->ga_id = $this->get_option('ga_id');
   $this->ga_IPA = $this->get_option('ga_IPA') == "on" ? true : false; //IP Anony.
   $this->ga_CG = $this->get_option('ga_CG') == "on" ? true : false; // Content Grouping
   $this->ga_CGInd = 5; // We have fixed CG index : 5  //CG Index
   $this->ga_eGTM = $this->get_option('ga_eGTM') == "on" ? true : false; //client GTM enable
   $this->ga_eeT = $this->get_option("ga_eeT");  // EE Tracking - never put true : false here
   $this->ga_cID = $this->get_option("ga_cID") == "on" ? true : false;
   $this->ga_DF = $this->get_option("ga_DF") == "on" ? true : false; //Display Feature
   $this->ga_imTh = 6; //Impression Threshold
   $this->ga_RTkn = $this->get_option("ga_RTkn"); //get refresh token
   //advance user defined values 
   $this->ga_IPA = $this->get_option("ga_IPA") == "on" ? true : false; //IP Anony.
   $this->ga_OPTOUT = $this->get_option("ga_OPTOUT") == "on" ? true : false; //IP Anony.
   $this->ga_404ET = $this->get_option("ga_404ET") == "on" ? true : false; //404 Error Tracking
   $this->ga_optimize = $this->get_option("ga_optimize") == "on" ? true : false;//Google Optimize featuer
   $this->ga_optimize_data = $this->get_option("ga_optimize_data");//Google Optimize ID
   $this->ga_optimize_delay = $this->get_option("ga_optimize_delay");//Optimize Page load delay
   $this->ga_hide_snippet = $this->get_option("ga_hide_snippet") == "on" ? true : false;;
   $this->ga_adwords = $this->get_option("ga_adwords") == "on" ? true : false;//Google AdWords featuer
   $this->ga_adwords_data = $this->get_option("ga_adwords_data");
   $this->fb_pixel = $this->get_option("fb_pixel") == "on" ? true : false;//Google AdWords featuer
   $this->t_purchase_code = $this->get_option("purchase_code");
   if (is_admin()) {
  return;
   }
   $this->fb_pixel_data = $this->get_option("fb_pixel_data");
   $this->ga_adwords_label = $this->get_option("ga_adwords_label");//Google AdWords Label
   $this->ga_UID = $this->get_option("ga_UID") == "on" ? true : false; // User ID
   $this->ga_FF = $this->get_option("ga_FF") == "on" ? true : false;  //Form Field Tracking
   $this->ga_InPromo = $this->get_option("ga_InPromo") == "on" ? true : false; // Internal Promotion
   $this->ga_InPromoData = $this->get_option("ga_InPromoData"); // IP Data
   $this->ga_PrivacyPolicy = $this->get_option("ga_PrivacyPolicy") == "on" ? true : false;
   $this->track = "";
   
   if (in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins')))) {
			// Put your plugin code here
  add_action('woocommerce_init', function () {
 $this->ga_LC = get_woocommerce_currency(); //Local Currency from Back end
 $this->wc_version_compare("tvc_lc=" . json_encode($this->ga_LC) . ";");
  });
   }
}

/**
* Get store meta data for trouble shoot
* @access public
* @return void
*/

function tvc_store_meta_data()
{
   //only on home page
   global $woocommerce;
   $tvc_sMetaData = array();
   $tvc_sMetaData = array(
  'tvc_wcv' => $woocommerce->version,
  'tvc_wpv' => get_bloginfo('version'),
  'tvc_eev' => $this->version,
  'tvc_cnf' => array(
 't_ee' => $this->ga_eeT,
 't_df' => $this->ga_DF,
 't_cID' => $this->ga_cID,
 't_thr' => $this->ga_imTh,
 't_uid' => $this->ga_UID,
 't_ip' => $this->ga_InPromo,
 't_OPTOUT' => $this->ga_OPTOUT,
 't_ipa' => $this->ga_IPA,
 't_ff' => $this->ga_FF,
 't_cg' => $this->ga_CG,
 't_404' => $this->ga_404ET,
 't_adwords' => $this->ga_adwords,
 't_fb_pixel' => $this->fb_pixel,
 't_ga_optimize' => $this->ga_optimize

  )
   );
   $this->wc_version_compare("tvc_smd=" . json_encode($tvc_sMetaData) . ";");
}

/**
* Register the stylesheets for the public-facing side of the site.
*
* @since1.0.0
*/
public function enqueue_styles()
{

   /**
* This function is provided for demonstration purposes only.
*
* An instance of this class should be passed to the run() function
* defined in Test_Loader as all of the hooks are defined
* in that particular class.
*
* The Test_Loader will then create the relationship
* between the defined hooks and the functions defined in this
* class.
*/

   wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/actionable-google-analytics-public.css', array(), $this->version, 'all');

}

/**
* Register the JavaScript for the public-facing side of the site.
*
* @since1.0.0
*/
public function enqueue_scripts()
{

   /**
* This function is provided for demonstration purposes only.
*
* An instance of this class should be passed to the run() function
* defined in Test_Loader as all of the hooks are defined
* in that particular class.
*
* The Test_Loader will then create the relationship
* between the defined hooks and the functions defined in this
* class.
*/

   wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/actionable-google-analytics-public.js', array('jquery'), $this->version, false);

}
public function get_option($key)
{
   $aga_admin_settings = array();
   $aga_options = array();
   $aga_optimize = array();
   $aga_conversion = array();
   $aga_advance_track = array();
   $aga_purchase_code = array();

   if (!empty(unserialize(get_option('aga_options')))) {
  $aga_options = unserialize(get_option('aga_options'));
   }
   if (!empty(unserialize(get_option('aga_optimize_settings')))) {
  $aga_optimize = unserialize(get_option('aga_optimize_settings'));
   }
   if (!empty(unserialize(get_option('aga_conversion_settings')))) {
  $aga_conversion = unserialize(get_option('aga_conversion_settings'));
   }
   if (!empty(unserialize(get_option('aga_advanced_tracking_settings')))) {
  $aga_advance_track = unserialize(get_option('aga_advanced_tracking_settings'));
   }
   if (!empty(unserialize(get_option('aga_purchase_code')))) {
  $aga_purchase_code = unserialize(get_option('aga_purchase_code'));
   }
   $aga_admin_settings = array_merge($aga_options, $aga_optimize, $aga_conversion, $aga_advance_track, $aga_purchase_code);
   if (isset($aga_admin_settings[$key])) {
  return $aga_admin_settings[$key];
   }
}
public function add_Analytics_code()
{

   if (is_order_received_page()) {
  $order_id = empty($_GET["order"]) ? ($GLOBALS["wp"]->query_vars["order-received"] ? $GLOBALS["wp"]->query_vars["order-received"] : 0) : absint($_GET["order"]);
  echo $this->thankyou_page_code($order_id);
   }
   $tracking_id = $this->ga_id;
   $set_domain_name = "auto";
   if (!$tracking_id || !$this->ga_PrivacyPolicy || $this->disable_tracking($this->ga_eeT)) {
  return;
   }
   $this->fb_tracking_code();

   if (!is_admin() || !is_admin_bar_showing()) {
  $t_page_type = $this->add_page_type();
  if ($this->ga_OPTOUT) {
 echo "<script>
 // Set to the same value as the web property used on the site
 var gaProperty = '" . $tracking_id . "';

 // Disable tracking if the opt-out cookie exists.
 var disableStr = 'ga-disable-' + gaProperty;
 if (document.cookie.indexOf(disableStr + '=true') > -1) {
   window[disableStr] = true;
 }

 // Opt-out function
 function gaOptout() {
				
 var expDate = new Date;
 expDate.setMonth(expDate.getMonth() + 26);
   document.cookie = disableStr + '=true; expires='+expDate.toGMTString()+'; path=/';
   window[disableStr] = true;
 }
 </script>";
  }
   //Google Optimize ID
  if ($this->ga_optimize_data && $this->ga_optimize) {
 if ($this->ga_optimize_delay) {
$page_hiding_delay = $this->ga_optimize_delay;
 } else {
$page_hiding_delay = "4000";
 }
 if (!$this->ga_hide_snippet) {
$ga_optimize_page_hide_snippet = '<!-- Google Optimize Page-hiding snippet By AGA Tatvic--><style>.async-hide { opacity: 0 !important} </style>
					<script>(function(a,s,y,n,c,h,i,d,e){s.className+=" "+y;h.start=1*new Date;
					h.end=i=function(){s.className=s.className.replace(RegExp(" ?"+y)," ")};
					(a[n]=a[n]||[]).hide=h;setTimeout(function(){i();h.end=null},c);h.timeout=c;
					})(window,document.documentElement,"async-hide","dataLayer","' . $page_hiding_delay . '",
					{"' . esc_js($this->ga_optimize_data) . '":true});</script>';
 } else {
$ga_optimize_page_hide_snippet = "";
 }


 $ga_optimize_code = 'ga("require","' . esc_js($this->ga_optimize_data) . '");';
  } else {
 $ga_optimize_page_hide_snippet = "";
 $ga_optimize_code = "";
  }

  // Code for Content Grouping
  if ($this->ga_CG) {
 //get content grouping ID
 $ga_cg_index = $this->ga_CGInd; //CG index fixed : 5
 $ga_content_grouping = 'ga("set", "contentGroup' . $ga_cg_index . '","' . $t_page_type . '");';
 
 //return $ga_content_grouping;
 $ga_content_grouping_code = $ga_content_grouping;

  } else {
 $ga_content_grouping_code = "";
  }

  $ga_pagetype = 'ga("set", "dimension2","' . $t_page_type . '");';
  //get ga content grouping code if it is enabled --- not on Admin side
  

  //add Pageview on order page if admin is logged in
  $ga_pageview = 'ga("send", "pageview",{siteSpeedSampleRate: 100});';

  // IP Anonymization
  if ($this->ga_IPA) {
 $ga_ip_anonymization = 'ga("set", "anonymizeIp", true);';
  } else {
 $ga_ip_anonymization = '';
  }

   } else {
  $ga_content_grouping_code = '';
  $ga_pageview = '';
   }
   if ($this->ga_cID) {
  $ga_client_id_tracking = 'ga(function(tracker) {
 tvc_clientID = tracker.get("clientId");
 ga("set", "dimension17", tvc_clientID);
  });';
   } else {
  $ga_client_id_tracking = '';
   }
   echo '
<!--Enhanced Ecommerce Google Analytics Plugin for Woocommerce by Tatvic. Plugin Version: ' . $this->version . '-version-->
   <script>(window.gaDevIds=window.gaDevIds||[]).push("5CDcaG");</script>
   ' . $ga_optimize_page_hide_snippet . '
   <script>   
   (function(i,s,o,g,r,a,m){i["GoogleAnalyticsObject"]=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,"script","//www.google-analytics.com/analytics.js","ga");
  ga("create", "' . esc_js($tracking_id) . '", "' . $set_domain_name . '");
  ' . $ga_optimize_code . '
  ' . $ga_client_id_tracking . '
ga("require", "displayfeatures");
ga("require", "ec", "ec.js");
' . $ga_content_grouping_code . '
' . $ga_ip_anonymization . '
' . $ga_pagetype . '
' . $ga_pageview . '
   </script>';

   //check if user has enable own GTM
   if (!$this->ga_eGTM) {
  echo '
 <!-- Google Tag Manager -->
 <noscript><iframe src="//www.googletagmanager.com/ns.html?id=GTM-TSHSWL"
 height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
 <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({"gtm.start":
 new Date().getTime(),event:"gtm.js"});var f=d.getElementsByTagName(s)[0],
 j=d.createElement(s),dl=l!="dataLayer"?"&l="+l:"";j.async=true;j.src=
 "//www.googletagmanager.com/gtm.js?id="+i+dl;f.parentNode.insertBefore(j,f);
 })(window,document,"script","dataLayer","GTM-TSHSWL");</script>
 <!-- End Google Tag Manager -->
  <!--Enhanced Ecommerce Google Analytics Plugin for Woocommerce by Tatvic. Plugin Version: ' . $this->version . '-version-->
  ';
   }
}
/**
* obfuscated email address for USER ID
* 
* @access public
* @return void
*/
function encode_email_id()
{
   if (is_user_logged_in() && !is_admin()) {
  $email_id = wp_get_current_user();
  $domain = get_site_url();
  $split_chr = strpos($domain, '//');
  $domain = substr($domain, $split_chr + 2);
  $t_uid = base64_encode($email_id->user_email);

   @setcookie('t_uid', $t_uid, time() + 3600 * 24, '/');
   }
}

/**
* USER ID tracking
* 
* @access public
* @return void
*/
function user_id_tracking()
{
   //User ID Implementation
   $user_id = "if(typeof(user_id_tracking)!=='undefined' && typeof(user_id_tracking) === 'function'){
user_id_tracking();
 }else{
t_userid_call=true;
 }
   ";
   //check user id is enabled or not
   if ($this->ga_UID)
  $this->wc_version_compare($user_id);
}

public function bind_product_metadata()
{

   if ($this->disable_tracking($this->ga_eeT)) {
  return;
   }
   global $product, $woocommerce;
   if (version_compare($woocommerce->version, "2.7", "<")) {
  $category = get_the_terms($product->ID, "product_cat");
   } else {
  $category = get_the_terms($product->get_id(), "product_cat");
   }
   $categories = "";
   if ($category) {
  foreach ($category as $term) {
 $categories .= $term->name . ",";
  }
   }
   //remove last comma(,) if multiple categories are there
   $categories = rtrim($categories, ",");
   //declare all variable as a global which will used for make json
   global $homepage_json_fp, $homepage_json_ATC_link, $homepage_json_rp, $prodpage_json_relProd, $catpage_json, $prodpage_json_ATC_link, $catpage_json_ATC_link;
   //is home page then make all necessory json
   if (is_home() || is_front_page()) {
  if (!is_array($homepage_json_fp) && !is_array($homepage_json_rp) && !is_array($homepage_json_ATC_link)) {
 $homepage_json_fp = array();
 $homepage_json_rp = array();
 $homepage_json_ATC_link = array();
  }
  // ATC link Array
  if (version_compare($woocommerce->version, "2.7", "<")) {
 $homepage_json_ATC_link[$product->add_to_cart_url()] = array("tvc_u" => get_permalink($product->id));
  } else {
 $homepage_json_ATC_link[$product->add_to_cart_url()] = array("tvc_u" => get_permalink($product->get_id()));
  }
  
  //check if product is featured product or not  
  if ($product->is_featured()) {
 //check if product is already exists in homepage featured json 
 if (version_compare($woocommerce->version, "2.7", "<")) {
if (!array_key_exists(get_permalink($product->id), $homepage_json_fp)) {

$homepage_json_fp[get_permalink($product->id)] = array(
   "tvc_id" => esc_html($product->id),
   "tvc_i" => esc_html($product->get_sku() ? $product->get_sku() : $product->id),
   "tvc_n" => esc_html($product->get_title()),
   "tvc_p" => esc_html($product->sale_price ? $product->sale_price : $product->get_price()),
   "tvc_c" => esc_html($categories),
   "tvc_ss" => $product->is_in_stock(),
   "tvc_st" => $product->get_stock_quantity(),
   "tvc_tst" => $product->get_total_stock(),
   "tvc_pd" => $this->cal_prod_discount($product->regular_price, $product->sale_price),
   "tvc_rc" => $product->get_rating_count(),
   "tvc_rs" => $product->get_average_rating(),
   "tvc_po" => ++$_SESSION['t_fpcnt']
);
//else add product in homepage recent product json
} else {
$homepage_json_rp[get_permalink($product->id)] = array(
   "tvc_id" => esc_html($product->id),
   "tvc_i" => esc_html($product->get_sku() ? $product->get_sku() : $product->id),
   "tvc_n" => esc_html($product->get_title()),
   "tvc_p" => esc_html($product->sale_price ? $product->sale_price : $product->get_price()),
   "tvc_c" => esc_html($categories),
   "tvc_ss" => $product->is_in_stock(),
   "tvc_st" => $product->get_stock_quantity(),
   "tvc_tst" => $product->get_total_stock(),
   "tvc_pd" => $this->cal_prod_discount($product->regular_price, $product->sale_price),
   "tvc_rc" => $product->get_rating_count(),
   "tvc_rs" => $product->get_average_rating(),
   "tvc_po" => ++$_SESSION['t_npcnt']
);
}
 } else {
if (!array_key_exists(get_permalink($product->get_id()), $homepage_json_fp)) {

$homepage_json_fp[get_permalink($product->get_id())] = array(
   "tvc_id" => esc_html($product->get_id()),
   "tvc_i" => esc_html($product->get_sku() ? $product->get_sku() : $product->get_id()),
   "tvc_n" => esc_html($product->get_title()),
   "tvc_p" => esc_html($product->get_sale_price() ? $product->get_sale_price() : $product->get_regular_price()),
   "tvc_c" => esc_html($categories),
   "tvc_ss" => $product->is_in_stock(),
   "tvc_st" => $product->get_stock_quantity(),
   "tvc_tst" => $product->get_stock_quantity(),
   "tvc_pd" => $this->cal_prod_discount($product->get_regular_price(), $product->get_sale_price()),
   "tvc_rc" => $product->get_rating_count(),
   "tvc_rs" => $product->get_average_rating(),
   "tvc_po" => ++$_SESSION['t_fpcnt']
);
//else add product in homepage recent product json
} else {
$homepage_json_rp[get_permalink($product->get_id())] = array(
   "tvc_id" => esc_html($product->get_id()),
   "tvc_i" => esc_html($product->get_sku() ? $product->get_sku() : $product->get_id()),
   "tvc_n" => esc_html($product->get_title()),
   "tvc_p" => esc_html($product->get_sale_price() ? $product->get_sale_price() : $product->get_regular_price()),
   "tvc_c" => esc_html($categories),
   "tvc_ss" => $product->is_in_stock(),
   "tvc_st" => $product->get_stock_quantity(),
   "tvc_tst" => $product->get_stock_quantity(),
   "tvc_pd" => $this->cal_prod_discount($product->get_regular_price(), $product->get_sale_price()),
   "tvc_rc" => $product->get_rating_count(),
   "tvc_rs" => $product->get_average_rating(),
   "tvc_po" => ++$_SESSION['t_npcnt']
);
}
 }
  } else {
 //else prod add in homepage recent json 
 if (version_compare($woocommerce->version, "2.7", "<")) {
$homepage_json_rp[get_permalink($product->id)] = array(
"tvc_id" => esc_html($product->id),
"tvc_i" => esc_html($product->get_sku() ? $product->get_sku() : $product->id),
"tvc_n" => esc_html($product->get_title()),
"tvc_p" => esc_html($product->sale_price ? $product->sale_price : $product->get_price()),
"tvc_c" => esc_html($categories),
"tvc_ss" => $product->is_in_stock(),
"tvc_st" => $product->get_stock_quantity(),
"tvc_pd" => $this->cal_prod_discount($product->regular_price, $product->sale_price),
"tvc_tst" => $product->get_total_stock(),
"tvc_rc" => $product->get_rating_count(),
"tvc_rs" => $product->get_average_rating(),
"tvc_po" => ++$_SESSION['t_npcnt']
);
 } else {
$homepage_json_rp[get_permalink($product->get_id())] = array(
"tvc_id" => esc_html($product->get_id()),
"tvc_i" => esc_html($product->get_sku() ? $product->get_sku() : $product->get_id()),
"tvc_n" => esc_html($product->get_title()),
"tvc_p" => esc_html($product->get_sale_price() ? $product->get_sale_price() : $product->get_regular_price()),
"tvc_c" => esc_html($categories),
"tvc_ss" => $product->is_in_stock(),
"tvc_st" => $product->get_stock_quantity(),
"tvc_pd" => $this->cal_prod_discount($product->get_regular_price(), $product->get_sale_price()),
"tvc_tst" => $product->get_stock_quantity(),
"tvc_rc" => $product->get_rating_count(),
"tvc_rs" => $product->get_average_rating(),
"tvc_po" => ++$_SESSION['t_npcnt']
);
 }
  }
   }
   //if product page then related product page array
   else if (is_product()) {
  if (!is_array($prodpage_json_relProd) && !is_array($prodpage_json_ATC_link)) {
 $prodpage_json_relProd = array();
 $prodpage_json_ATC_link = array();
  }
  // ATC link Array
  if (version_compare($woocommerce->version, "2.7", "<")) {
 $prodpage_json_ATC_link[$product->add_to_cart_url()] = array("tvc_u" => get_permalink($product->id));

 $prodpage_json_relProd[get_permalink($product->id)] = array(
"tvc_id" => esc_html($product->id),
"tvc_i" => esc_html($product->get_sku() ? $product->get_sku() : $product->id),
"tvc_n" => esc_html($product->get_title()),
"tvc_p" => esc_html($product->sale_price ? $product->sale_price : $product->get_price()),
"tvc_c" => esc_html($categories),
"tvc_ss" => $product->is_in_stock(),
"tvc_st" => $product->get_stock_quantity(),
"tvc_pd" => $this->cal_prod_discount($product->regular_price, $product->sale_price),
"tvc_tst" => $product->get_total_stock(),
"tvc_rc" => $product->get_rating_count(),
"tvc_rs" => $product->get_average_rating(),
"tvc_po" => ++$_SESSION['t_npcnt']
 );
  } else {
 $prodpage_json_ATC_link[$product->add_to_cart_url()] = array("tvc_u" => get_permalink($product->get_id()));

 $prodpage_json_relProd[get_permalink($product->get_id())] = array(
"tvc_id" => esc_html($product->get_id()),
"tvc_i" => esc_html($product->get_sku() ? $product->get_sku() : $product->get_id()),
"tvc_n" => esc_html($product->get_title()),
"tvc_p" => esc_html($product->get_sale_price() ? $product->get_sale_price() : $product->get_regular_price()),
"tvc_c" => esc_html($categories),
"tvc_ss" => $product->is_in_stock(),
"tvc_st" => $product->get_stock_quantity(),
"tvc_pd" => $this->cal_prod_discount($product->get_regular_price(), $product->get_sale_price()),
"tvc_tst" => $product->get_stock_quantity(),
"tvc_rc" => $product->get_rating_count(),
"tvc_rs" => $product->get_average_rating(),
"tvc_po" => ++$_SESSION['t_npcnt']
 );
  }
   }
   //category page, search page and shop page json
   else if (is_product_category() || is_search() || is_shop()) {
  if (!is_array($catpage_json) && !is_array($catpage_json_ATC_link)) {
 $catpage_json = array();
 $catpage_json_ATC_link = array();
  }
  //cat page ATC array
  if (version_compare($woocommerce->version, "2.7", "<")) {
 $catpage_json_ATC_link[$product->add_to_cart_url()] = array("tvc_u" => get_permalink($product->id));

 $catpage_json[get_permalink($product->id)] = array(
"tvc_id" => esc_html($product->id),
"tvc_i" => esc_html($product->get_sku() ? $product->get_sku() : $product->id),
"tvc_n" => esc_html($product->get_title()),
"tvc_p" => esc_html($product->sale_price ? $product->sale_price : $product->get_price()),
"tvc_c" => esc_html($categories),
"tvc_ss" => $product->is_in_stock(),
"tvc_st" => $product->get_stock_quantity(),
"tvc_pd" => $this->cal_prod_discount($product->regular_price, $product->sale_price),
"tvc_tst" => $product->get_total_stock(),
"tvc_rc" => $product->get_rating_count(),
"tvc_rs" => $product->get_average_rating(),
"tvc_po" => ++$_SESSION['t_npcnt']
 );
  } else {
 $catpage_json_ATC_link[$product->add_to_cart_url()] = array("tvc_u" => get_permalink($product->get_id()));

 $catpage_json[get_permalink($product->get_id())] = array(
"tvc_id" => esc_html($product->get_id()),
"tvc_i" => esc_html($product->get_sku() ? $product->get_sku() : $product->get_id()),
"tvc_n" => esc_html($product->get_title()),
"tvc_p" => esc_html($product->get_sale_price() ? $product->get_sale_price() : $product->get_regular_price()),
"tvc_c" => esc_html($categories),
"tvc_ss" => $product->is_in_stock(),
"tvc_st" => $product->get_stock_quantity(),
"tvc_pd" => $this->cal_prod_discount($product->get_regular_price(), $product->get_sale_price()),
"tvc_tst" => $product->get_stock_quantity(),
"tvc_rc" => $product->get_rating_count(),
"tvc_rs" => $product->get_average_rating(),
"tvc_po" => ++$_SESSION['t_npcnt']
 );
  }

   }
}

/**
* Enhanced E-commerce tracking for product impressions,clicks on Home pages
*
* @access public
* @return void
*/
public function t_products_impre_clicks()
{
   if ($this->disable_tracking($this->ga_eeT)) {
  return;
   }
   //get impression threshold
   $impression_threshold = $this->ga_imTh;

   //Product impression on Home Page
   global $homepage_json_fp, $homepage_json_ATC_link, $homepage_json_rp, $prodpage_json_relProd, $catpage_json, $prodpage_json_ATC_link, $catpage_json_ATC_link;
   //home page json for featured products and recent product sections
   //check if php array is empty
   if (empty($homepage_json_ATC_link)) {
  $homepage_json_ATC_link = array(); //define empty array so if empty then in json will be []
   }
   if (empty($homepage_json_fp)) {
  $homepage_json_fp = array(); //define empty array so if empty then in json will be []
   }
   if (empty($homepage_json_rp)) { //home page recent product array
  $homepage_json_rp = array();
   }
   if (empty($prodpage_json_relProd)) { //prod page related section array
  $prodpage_json_relProd = array();
   }
   if (empty($prodpage_json_ATC_link)) {
  $prodpage_json_ATC_link = array(); //prod page ATC link json
   }
   if (empty($catpage_json)) { //category page array
  $catpage_json = array();
   }
   if (empty($catpage_json_ATC_link)) { //category page array
  $catpage_json_ATC_link = array();
   }
   //home page json
   $this->wc_version_compare("tvc_h_a=" . json_encode($homepage_json_ATC_link) . ";");
   $this->wc_version_compare("tvc_fp=" . json_encode($homepage_json_fp) . ";");
   $this->wc_version_compare("tvc_rcp=" . json_encode($homepage_json_rp) . ";");
   //product page json
   $this->wc_version_compare("tvc_rdp=" . json_encode($prodpage_json_relProd) . ";");
   $this->wc_version_compare("tvc_p_a=" . json_encode($prodpage_json_ATC_link) . ";");
   //category page, search page and shop page json
   $this->wc_version_compare("tvc_pgc=" . json_encode($catpage_json) . ";");
   $this->wc_version_compare("tvc_c_a=" . json_encode($catpage_json_ATC_link) . ";");

   $t_products_actions_js = '
 //Set Impression Threshold
 tvc_thr =' . esc_js($impression_threshold) . ';';

   if (is_home() || is_front_page()) {
  $t_products_actions_js .= '
//call featured product impression
 if(typeof(hmpg_impressions_FP)!=="undefined" && typeof(hmpg_impressions_FP) === "function"){
hmpg_impressions_FP();
   }else{
t_hmpgImprFP_call=true; 
 }
 //call recent product impression
 if(typeof(hmpg_impressions_RP)!=="undefined" && typeof(hmpg_impressions_RP) === "function"){
hmpg_impressions_RP();
   }else{
t_hmpgImprRP_call=true; 
 }
 //to measure product click on home page
 if(typeof(t_products_clicks)!=="undefined" && typeof(t_products_clicks) === "function"){
t_products_clicks(tvc_fp,"fp","Featured Products"); //json name , action name , list name
   }else{
t_hmpgClick_call=true;
   }

 //to measure product ATC on home page
 if(typeof(t_products_ATC)!=="undefined" && typeof(t_products_ATC) === "function"){
t_products_ATC(tvc_h_a,tvc_fp);
   }else{
t_hmpgATC_call=true;
   } 
 
 ';
   } else if (is_search()) {
  $t_products_actions_js .= '
 //to measure product impression on Search page
  if(typeof(t_products_impressions)!=="undefined" && typeof(t_products_impressions) === "function"){
t_products_impressions(tvc_pgc,"srch","Search Results");
   }else{
t_spImpr_call=true; 
 } 
  //to measure product click on Search page
 if(typeof(t_products_clicks)!=="undefined" && typeof(t_products_clicks) === "function"){
t_products_clicks(tvc_pgc,"srch","Search Results"); //json name , action name , list name
   }else{
t_srchpClick_call=true;
   }
 
   ';
   } else if (is_product()) {
  //product page releted products
  $t_products_actions_js .= '
  //to measure related product impression on product page
  if(typeof(t_products_impressions)!=="undefined" && typeof(t_products_impressions) === "function"){
t_products_impressions(tvc_rdp,"rdp","Related Products");
   }else{
t_ppImprRDP_call=true; 
 } 
  //to measure product click on product page
 if(typeof(t_products_clicks)!=="undefined" && typeof(t_products_clicks) === "function"){
t_products_clicks(tvc_rdp,"rdp","Related Products"); //json name , action name , list name
   }else{
t_ppClickRDP_call=true;
   }
  //to measure product ATC on product page (RDP)
 if(typeof(t_products_ATC)!=="undefined" && typeof(t_products_ATC) === "function"){
t_products_ATC(tvc_p_a,tvc_rdp);
   }else{
t_ppATCrdp_call=true;
   } 
 ';
   } else if (is_product_category()) {
  $t_products_actions_js .= '
 //to measure product impression on Category page
  if(typeof(t_products_impressions)!=="undefined" && typeof(t_products_impressions) === "function"){
t_products_impressions(tvc_pgc,"cp","Category Page");
   }else{
t_cpImpr_call=true; 
 } 
  //to measure product click on Category page
 if(typeof(t_products_clicks)!=="undefined" && typeof(t_products_clicks) === "function"){
t_products_clicks(tvc_pgc,"cp","Category Page"); //json name , action name , list name
   }else{
t_cpClick_call=true;
   }

';
   } else if (is_shop()) {
  $t_products_actions_js .= '
//to measure product impression on shop page
  if(typeof(t_products_impressions)!=="undefined" && typeof(t_products_impressions) === "function"){
t_products_impressions(tvc_pgc,"sp","Shop Page");
   }else{
t_spImpr_call=true; 
 } 
  //to measure product click on shop page
 if(typeof(t_products_clicks)!=="undefined" && typeof(t_products_clicks) === "function"){
t_products_clicks(tvc_pgc,"sp","Shop Page"); //json name , action name , list name
   }else{
t_spClick_call=true;
   }
 
   ';
   } 
   //common ATC link for Category page , Shop Page and Search Page
   if (is_product_category() || is_shop() || is_search()) {
  $t_products_actions_js .= '
   //to measure product ATC on CP,SP,SrchPage
 if(typeof(t_products_ATC)!=="undefined" && typeof(t_products_ATC) === "function"){
t_products_ATC(tvc_c_a,tvc_pgc);
   }else{
t_commonATC_call=true;
   } 
';
   }

   //on home page, product page , category page
   if (is_home() || is_front_page() || is_product() || is_product_category() || is_search() || is_shop()) {
  $this->wc_version_compare($t_products_actions_js);
   }
}

/**
* Google Analytics eCommerce tracking
*
* @access public
* @param mixed $order_id
* @return void
*/
function thankyou_page_code($order_id)
{

   global $woocommerce;
   $fb_purchase_code = "";
   //  if ($this->disable_tracking($this->ga_eeT) || get_post_meta($order_id, "tvc_tracked", true) == 1 )
   //     return false;

   // Get the order and output tracking code
   $order = new WC_Order($order_id);
   //Get Applied Coupon Codes
   $coupons_list = '';
   if ($order->get_used_coupons()) {
  $coupons_count = count($order->get_used_coupons());
  $i = 1;
  foreach ($order->get_used_coupons() as $coupon) {
   $coupons_list .= $coupon;
   if ($i < $coupons_count)
   $coupons_list .= ', ';
   $i++;
  }
   }
   if ($order->get_items()) {

  $i = 0;
  foreach ($order->get_items() as $item) {
 $_product = $order->get_product_from_item($item);
 $tvc_prnm = get_the_title($item['product_id']);
 
 //get product categories
 $tmp_cat = array();
 if (version_compare($woocommerce->version, "2.7", "<")) {
$categories = get_the_terms($item['product_id'], "product_cat");

 } else {
$categories = get_the_terms($item['product_id'], "product_cat");
 }
 if ($categories) {
foreach ($categories as $category) {
$tmp_cat[] = $category->name;
}
 }
 $categories = esc_js(join(",", $tmp_cat));
 
 //check if product variation data is exists
 if (version_compare($woocommerce->version, "2.7", "<")) {
if ($_product->product_type === "variation") {
//variant data
$prod_var_array = $_product->get_variation_attributes();
//get var product weight
$t_wt = '';
if ($_product->variation_has_weight) {
   $t_wt = $_product->get_weight() . ' ' . esc_attr(get_option('woocommerce_weight_unit'));
}
} else if ($_product->product_type === 'simple') {
//for simple product it's should be blank array
$prod_var_array = array();
//get product weight
$t_wt = '';
if ($_product->has_weight()) {
   $t_wt = $_product->get_weight() . ' ' . esc_attr(get_option('woocommerce_weight_unit'));
}
}
 //orderpage Variable Prod Array
$orderpage_prod_Array[$i] = array(
"tvc_id" => esc_html($_product->id),
"tvc_i" => esc_js($_product->sku ? $_product->sku : $_product->id),
"tvc_n" => $tvc_prnm,
"tvc_p" => esc_js($order->get_item_total($item)),
"tvc_rp" => $_product->regular_price,
"tvc_sp" => $_product->sale_price,
"tvc_pd" => $this->cal_prod_discount($_product->regular_price, $_product->sale_price),
"tvc_c" => $categories,
"tvc_q" => esc_js($item["qty"]),
"tvc_vat" => $prod_var_array,
"tvc_wt" => $t_wt,
"tvc_di" => $_product->get_dimensions(), //dimensions
"tvc_ss" => $_product->is_in_stock(),
"tvc_st" => $_product->get_stock_quantity(),
"tvc_tst" => $_product->get_total_stock(),
"tvc_rc" => $_product->get_rating_count(),
"tvc_rs" => $_product->get_average_rating()
);
 } else {
if ($_product->get_type() === "variation") {
//variant data
$prod_var_array = $_product->get_variation_attributes();
//get var product weight
$t_wt = '';
if ($_product->get_weight() == "") {
   $t_wt = $_product->get_weight() . ' ' . esc_attr(get_option('woocommerce_weight_unit'));
}
} else if ($_product->get_type() === 'simple') {
//for simple product it's should be blank array
$prod_var_array = array();
//get product weight
$t_wt = '';
if ($_product->has_weight()) {
   $t_wt = $_product->get_weight() . ' ' . esc_attr(get_option('woocommerce_weight_unit'));
}
} else if ($_product->get_type() === 'yith_bundle' || $_product->get_type() === 'woosb') {
//for simple product it's should be blank array
$prod_var_array = array();
//get product weight
$t_wt = '';
if ($_product->has_weight()) {
   $t_wt = $_product->get_weight() . ' ' . esc_attr(get_option('woocommerce_weight_unit'));
}
}
 //orderpage Variable Prod Array
$orderpage_prod_Array[$i] = array(
"tvc_id" => esc_html($_product->get_id()),
"tvc_i" => esc_js($_product->get_sku() ? $_product->get_sku() : $_product->get_id()),
"tvc_n" => $_product->get_title(),
"tvc_p" => esc_js($order->get_item_total($item)),
"tvc_rp" => $_product->get_regular_price(),
"tvc_sp" => $_product->get_sale_price(),
"tvc_pd" => $this->cal_prod_discount($_product->get_regular_price(), $_product->get_sale_price()),
"tvc_c" => $categories,
"tvc_q" => esc_js($item["qty"]),
"tvc_vat" => $prod_var_array,
"tvc_wt" => $t_wt,
//"tvc_di" => $_product->get_dimensions(), //dimensions
"tvc_ss" => $_product->is_in_stock(),
"tvc_st" => $_product->get_stock_quantity(),
"tvc_tst" => $_product->get_stock_quantity(),
"tvc_rc" => $_product->get_rating_count(),
"tvc_rs" => $_product->get_average_rating()
);
 }
 $fb_purchase_code .= "{'id':'" . $orderpage_prod_Array[$i]['tvc_i'] . "','quantity':'" . $orderpage_prod_Array[$i]['tvc_q'] . "','item_price':'" . $orderpage_prod_Array[$i]['tvc_p'] . "'},";

 $i++;
  }
  //make json for prod meta data on order page
  $this->wc_version_compare("tvc_oc=" . json_encode($orderpage_prod_Array) . ";");
  //get user type
  $t_user_id = wp_get_current_user();
  $user_bill_addr = "";
  $user_ship_addr = "";
  if (0 == $t_user_id->ID) {
 $t_ut = 'guest_user';
  } else {
 $t_ut = 'register_user';
 //get city of registed user
 $user_bill_addr = get_user_meta($t_user_id->ID, 'shipping_city', true);
 $user_ship_addr = get_user_meta($t_user_id->ID, 'billing_city', true);
  }

  //get shipping cost based on version >2.1 get_total_shipping() < get_shipping
  if (version_compare($woocommerce->version, "2.1", ">=")) {
 $tvc_sc = $order->get_total_shipping();
  } else {
 $tvc_sc = $order->get_shipping();
  }

  //orderpage transcation data json
  if (version_compare($woocommerce->version, "2.7", "<")) {
 $orderpage_trans_Array = array(
"tvc_tid" => esc_js($order->get_order_number()), // Transaction ID. Required
"tvc_af" => esc_js(get_bloginfo('name')), // Affiliation or store name
"tvc_rev" => esc_js($order->get_total()), // Grand Total
"tvc_tt" => esc_js($order->get_total_tax()), // Tax
"tvc_sc" => $tvc_sc, // Shipping cost
"tvc_dc" => $coupons_list, //coupon code
"tvc_cd" => esc_js($order->get_total_discount()), //cart discount
"tvc_ut" => $t_ut, //user type
"tvc_bad" => $user_bill_addr, //billing addr
"tvc_sad" => $user_ship_addr, //shipping addr
"tvc_pm" => $order->payment_method_title //payment method
 );
  } else {
 $orderpage_trans_Array = array(
"tvc_tid" => esc_js($order->get_order_number()), // Transaction ID. Required
"tvc_af" => esc_js(get_bloginfo('name')), // Affiliation or store name
"tvc_rev" => esc_js($order->get_total()), // Grand Total
"tvc_tt" => esc_js($order->get_total_tax()), // Tax
"tvc_sc" => $tvc_sc, // Shipping cost
"tvc_dc" => $coupons_list, //coupon code
"tvc_cd" => esc_js($order->get_total_discount()), //cart discount
"tvc_ut" => $t_ut, //user type
"tvc_bad" => $user_bill_addr, //billing addr
"tvc_sad" => $user_ship_addr, //shipping addr
"tvc_pm" => $order->get_payment_method() //payment method
 );
  }
  
  //make json for trans data on order page


  $this->wc_version_compare("tvc_td=" . json_encode($orderpage_trans_Array) . ";");
  if ($this->fb_pixel && $this->fb_pixel_data) {
      $this->track .= "fbq('track', 'Purchase',{ 
      'value': '" . $order->get_total() . "',
      'currency':'" . $this->ga_LC . "',
      'content_type':'product',
      'contents':[$fb_purchase_code]
      })";
  }

   update_post_meta($order_id, "tvc_tracked", 1);
   }
}

/**
* Enhanced E-commerce tracking for single product add to cart (product page)
*
* @access public
* @return void
*/
function add_to_cart()
{
   if ($this->disable_tracking($this->ga_eeT))
  return;
   //return if not product page  
   if (!is_single())
  return;

   $add_to_cart_js = ' 
if(typeof(single_ATC)!=="undefined" && typeof(single_ATC) === "function"){
   single_ATC();
}else{
   t_sATC_call=true;   
}

   ';
   //check woocommerce version
   $this->wc_version_compare($add_to_cart_js);
}

/**
* Enhanced E-commerce tracking for product detail view
*
* @access public
* @return void
*/
public function product_detail_view()
{

   if ($this->disable_tracking($this->ga_eeT)) {
  return;
   }

   global $product, $woocommerce;
   $tvc_product_id = "";
   $prod_ids = "";
   if (version_compare($woocommerce->version, "2.7", "<")) {
  $category = get_the_terms($product->ID, "product_cat");
   } else {
  $category = get_the_terms($product->get_id(), "product_cat");
   }
   $categories = "";
   if ($category) {
  foreach ($category as $term) {
 $categories .= $term->name . ",";
  }
   }
   //check if product is variable product and product has child products
   if ($product->is_type('variable') && $product->has_child()) {
  //Get All variations IDs
  $t_var_ids = $product->get_children();

  //looping to get all variation data
  for ($i = 0; $i < sizeof($t_var_ids); $i++) {
 $t_var_metadata = wc_get_product($t_var_ids[$i]);
 $t_var_sku = $t_var_metadata->get_sku(); //get sku
 $t_var_prc = $t_var_metadata->get_sale_price() ? $t_var_metadata->get_sale_price() : $t_var_metadata->get_regular_price(); //get price
 $t_var_sprc = $t_var_metadata->get_sale_price(); //get sale price
 $t_var_rprc = $t_var_metadata->get_regular_price(); //get regular price
 //get var product weight
 $t_vwt = '';
 if ($t_var_metadata->get_weight() == "") {
$t_vwt = $t_var_metadata->get_weight() . ' ' . esc_attr(get_option('woocommerce_weight_unit'));
 }

 $prod_var_array[$t_var_ids[$i]] = array(
"tvc_vi" => $t_var_sku, //variation sku
"tvc_vp" => $t_var_prc, // get price
"tvc_vsp" => $t_var_sprc, //get sale price
"tvc_vrp" => $t_var_rprc, //get regular price
"tvc_pd" => $this->cal_prod_discount($t_var_rprc, $t_var_sprc),
"tvc_vat" => $t_var_metadata->get_variation_attributes(), //get avialable attr
"tvc_vwt" => $t_vwt, //get weight
//"tvc_vdi" => $t_var_metadata->get_dimensions(), //dimensions
"tvc_vss" => $t_var_metadata->is_in_stock(), //check stock status
"tvc_vst" => $t_var_metadata->get_stock_quantity(), //stock quantity
"tvc_vtst" => $t_var_metadata->get_stock_quantity() //total stock with variation count
 );
 $tvc_product_id .= $prod_var_array[$t_var_ids[$i]]["tvc_vi"] . ",";

  }
   } else {
  $prod_var_array = array();
   }

   //remove last comma(,) if multiple categories are there
   $categories = rtrim($categories, ",");
   //get product weight
   $t_wt = '';
   if ($product->has_weight()) {
  $t_wt = $product->get_weight() . ' ' . esc_attr(get_option('woocommerce_weight_unit')); //cond. here bcoz of weight unit
   }
   //product detail view json
   if (version_compare($woocommerce->version, "2.7", "<")) {
  $prodpage_detail_json = array(
 "tvc_i" => $product->get_sku() ? $product->get_sku() : $product->id,
 "tvc_n" => $product->get_title(),
 "tvc_c" => $categories,
 "tvc_p" => $product->sale_price ? $product->sale_price : $product->get_price(),
 "tvc_ss" => $product->is_in_stock(),
 "tvc_st" => $product->get_stock_quantity(),
 "tvc_tst" => $product->get_total_stock(),
 "tvc_var" => $prod_var_array,
 "tvc_rp" => $product->regular_price,
 "tvc_sp" => $product->sale_price,
 "tvc_pd" => $this->cal_prod_discount($product->regular_price, $product->sale_price),
 "tvc_wt" => $t_wt,
 "tvc_di" => $product->get_dimensions(), //dimensions
 "tvc_rc" => $product->get_rating_count(),
 "tvc_rs" => $product->get_average_rating() != '' ? $product->get_average_rating() : '0'
  );
   } else {
  $prodpage_detail_json = array(
 "tvc_i" => $product->get_sku() ? $product->get_sku() : $product->get_id(),
 "tvc_n" => $product->get_title(),
 "tvc_c" => $categories,
 "tvc_p" => $product->get_sale_price() ? $product->get_sale_price() : $product->get_regular_price(),
 "tvc_ss" => $product->is_in_stock(),
 "tvc_st" => $product->get_stock_quantity(),
 "tvc_tst" => $product->get_stock_quantity(),
 "tvc_var" => $prod_var_array,
 "tvc_rp" => $product->get_regular_price(),
 "tvc_sp" => $product->get_sale_price(),
 "tvc_pd" => $this->cal_prod_discount($product->get_regular_price(), $product->get_sale_price()),
 "tvc_wt" => $t_wt,
  //"tvc_di" => $product->get_dimensions(), //dimensions
 "tvc_rc" => $product->get_rating_count(),
 "tvc_rs" => $product->get_average_rating() != '' ? $product->get_average_rating() : '0'
  );
   }

   if (empty($prodpage_detail_json)) { //prod page array
  $prodpage_detail_json = array();
   }
   //prod page detail view json
   if ($this->fb_pixel && $this->fb_pixel_data) {
  $tvc_product_id = rtrim($tvc_product_id, ',');
  $prod_ids = $tvc_product_id ? $tvc_product_id : $prodpage_detail_json['tvc_i'];
  echo "<script>
  fbq('track', 'ViewContent', {
 'content_name':'" . $prodpage_detail_json['tvc_n'] . "',
 'content_type':'product',
 'content_ids':['" . $prod_ids . "'],
 'content_category':'" . $prodpage_detail_json['tvc_c'] . "',
 'value': '" . $prodpage_detail_json['tvc_p'] . "',
 'currency':'" . $this->ga_LC . "',
  });
  jQuery(\"button[class*='btn-buy-shop'],button[class*='single_add_to_cart_button'], button[class*='add_to_cart']\").click(function(){
 var t_var_id = jQuery(this).parents('form').find(\"input[name='variation_id']\").val();
 var tvc_price;
 var tvc_prod_id;
 if(t_var_id){
var prod_var_array = '" . json_encode($prodpage_detail_json['tvc_var']) . "';
var tvc_var_prod = JSON.parse(prod_var_array);
tvc_prod_id = tvc_var_prod[t_var_id].tvc_vi;
tvc_price = tvc_var_prod[t_var_id].tvc_vp;
 }
 else{
tvc_prod_id = '" . $prodpage_detail_json['tvc_i'] . "'
tvc_price = '" . $prodpage_detail_json['tvc_p'] . "';
 }
 fbq('track', 'AddToCart', {
'content_name':'" . $prodpage_detail_json['tvc_n'] . "',
'content_type':'product',
'content_ids':[tvc_prod_id],
'content_category':'" . $prodpage_detail_json['tvc_c'] . "',
'value': tvc_price,
'currency':'" . $this->ga_LC . "',
 });
  });
  </script>";

   }
   $this->wc_version_compare("tvc_po=" . json_encode($prodpage_detail_json) . ";");

   //call function to fire detail view of product
   $prod_detail_view_js = '
  if(typeof(prod_detail_view)!=="undefined" && typeof(prod_detail_view) === "function"){
 prod_detail_view();
   }else{
   t_pDetail_call=true;
}';
   //check woocommerce version
   $this->wc_version_compare($prod_detail_view_js);
}

/**
* Enhanced E-commerce tracking for remove from cart
*
* @access public
* @return void
*/
public function remove_cart_tracking()
{
   if ($this->disable_tracking($this->ga_eeT)) {
  return;
   }
   global $woocommerce;
   $cartpage_prod_array_main = array();
   //check if product is variable product and product has child products

   foreach ($woocommerce->cart->cart_contents as $key => $item) {

  $prod_meta = wc_get_product($item["product_id"]);
  //get remove from cart link 
  if (version_compare($woocommerce->version, "3.3", "<")) {
 $cart_remove_link = html_entity_decode($woocommerce->cart->get_remove_url($key));
  } else {
 $cart_remove_link = html_entity_decode(wc_get_cart_remove_url($key));
  }
  $category = get_the_terms($item["product_id"], "product_cat");
  $categories = "";
  if ($category) {
 foreach ($category as $term) {
$categories .= $term->name . ",";
 }
  }
  //remove last comma(,) if multiple categories are there
  $categories = rtrim($categories, ",");
  //for variable product

  if ($prod_meta->is_type('variable') && $prod_meta->has_child()) {
 $t_var_metadata = wc_get_product($item["variation_id"]);
 $t_var_sku = $t_var_metadata->get_sku();
 $t_var_prc = $t_var_metadata->get_sale_price() ? $t_var_metadata->get_sale_price() : $t_var_metadata->get_regular_price(); //get price
 $t_var_sprc = $t_var_metadata->get_sale_price(); //get sale price
 $t_var_rprc = $t_var_metadata->get_regular_price(); //get regular price
 //get var product weight
 $t_var_wt = '';
 if ($t_var_metadata->get_weight() == "") {
$t_var_wt = $t_var_metadata->get_weight() . ' ' . esc_attr(get_option('woocommerce_weight_unit')); //cond. here bcoz of weight unit
 }
 if (version_compare($woocommerce->version, "2.7", "<")) {
$cartpage_prod_array_main[$cart_remove_link] = array(
"tvc_id" => esc_html($prod_meta->id),
"tvc_i" => esc_html($t_var_sku),
"tvc_n" => esc_html($prod_meta->get_title()),
"tvc_p" => esc_html($t_var_prc),
"tvc_c" => esc_html($categories),
"tvc_q" => $woocommerce->cart->cart_contents[$key]["quantity"],
"tvc_sp" => $t_var_sprc, //get sale price
"tvc_rp" => $t_var_rprc, //get regular price
"tvc_vat" => $t_var_metadata->get_variation_attributes(), //get avialable attr
"tvc_wt" => $t_var_wt,
"tvc_pd" => $this->cal_prod_discount($t_var_rprc, $t_var_sprc),
"tvc_di" => $t_var_metadata->get_dimensions(), //dimensions
"tvc_ss" => $t_var_metadata->is_in_stock(),
"tvc_st" => $t_var_metadata->get_stock_quantity(),
"tvc_tst" => $t_var_metadata->get_total_stock(),
);
 } else {
$cartpage_prod_array_main[$cart_remove_link] = array(
"tvc_id" => esc_html($prod_meta->get_id()),
"tvc_i" => esc_html($t_var_sku),
"tvc_n" => esc_html($prod_meta->get_title()),
"tvc_p" => esc_html($t_var_prc),
"tvc_c" => esc_html($categories),
"tvc_q" => $woocommerce->cart->cart_contents[$key]["quantity"],
"tvc_sp" => $t_var_sprc, //get sale price
"tvc_rp" => $t_var_rprc, //get regular price
"tvc_vat" => $t_var_metadata->get_variation_attributes(), //get avialable attr
"tvc_wt" => $t_var_wt,
"tvc_pd" => $this->cal_prod_discount($t_var_rprc, $t_var_sprc),
//"tvc_di" => $t_var_metadata->get_dimensions(), //dimensions
"tvc_ss" => $t_var_metadata->is_in_stock(),
"tvc_st" => $t_var_metadata->get_stock_quantity(),
"tvc_tst" => $t_var_metadata->get_stock_quantity(),
);
 }

  } else if ($prod_meta->is_type('simple') || $prod_meta->is_type('woosb') || $prod_meta->is_type('yith_bundle')) {
 //get product weight
 $t_wt = '';
 if ($prod_meta->has_weight()) {
$t_wt = $prod_meta->get_weight() . ' ' . esc_attr(get_option('woocommerce_weight_unit')); //cond. here bcoz of weight unit
 }
 if (version_compare($woocommerce->version, "2.7", "<")) {
$cartpage_prod_array_main[$cart_remove_link] = array(
"tvc_id" => esc_html($prod_meta->id),
"tvc_i" => esc_html($prod_meta->get_sku() ? $prod_meta->get_sku() : $prod_meta->id),
"tvc_n" => esc_html($prod_meta->get_title()),
"tvc_p" => esc_html($prod_meta->sale_price ? $prod_meta->sale_price : $prod_meta->get_price()),
"tvc_pd" => $this->cal_prod_discount($prod_meta->regular_price, $prod_meta->sale_price),
"tvc_c" => esc_html($categories),
"tvc_q" => $woocommerce->cart->cart_contents[$key]["quantity"],
"tvc_wt" => $t_wt,
"tvc_di" => $prod_meta->get_dimensions(), //dimensions 
"tvc_ss" => $prod_meta->is_in_stock(),
"tvc_st" => $prod_meta->get_stock_quantity(),
"tvc_tst" => $prod_meta->get_total_stock(),
"tvc_rc" => $prod_meta->get_rating_count(),
"tvc_rs" => $prod_meta->get_average_rating()
);
 } else {
$cartpage_prod_array_main[$cart_remove_link] = array(
"tvc_id" => esc_html($prod_meta->get_id()),
"tvc_i" => esc_html($prod_meta->get_sku() ? $prod_meta->get_sku() : $prod_meta->get_id()),
"tvc_n" => esc_html($prod_meta->get_title()),
"tvc_p" => esc_html($prod_meta->get_sale_price() ? $prod_meta->get_sale_price() : $prod_meta->get_regular_price()),
"tvc_pd" => $this->cal_prod_discount($prod_meta->get_regular_price(), $prod_meta->get_sale_price()),
"tvc_c" => esc_html($categories),
"tvc_q" => $woocommerce->cart->cart_contents[$key]["quantity"],
"tvc_wt" => $t_wt,
//"tvc_di" => $prod_meta->get_dimensions(), //dimensions 
"tvc_ss" => $prod_meta->is_in_stock(),
"tvc_st" => $prod_meta->get_stock_quantity(),
"tvc_tst" => $prod_meta->get_stock_quantity(),
"tvc_rc" => $prod_meta->get_rating_count(),
"tvc_rs" => $prod_meta->get_average_rating()
);
 }

  }

   }

   //Cart Page item Array to Json
   $this->wc_version_compare("tvc_cc=" . json_encode($cartpage_prod_array_main) . ";");

   $remove_from_cart_js = '
  if(typeof(remove_from_cart)!=="undefined" && typeof(remove_from_cart) === "function"){
   remove_from_cart();
  }else{
 t_remove_call=true;
  }';
   //check woocommerce version
   $this->wc_version_compare($remove_from_cart_js);
}

/**
* Enhanced E-commerce tracking checkout step 1 and step 2
*
* @access public
* @return void
*/
public function checkout_step_1_2_tracking()
{
   if ($this->disable_tracking($this->ga_eeT)) {
  return;
   }
   //call fn to make checkout page json
   $this->get_ordered_items();
   //if logged in and first name is filled - Guest Check out
   if (is_user_logged_in()) {
  $step2_onFocus = ' 
  if(typeof(checkout_step1)!=="undefined" && typeof(checkout_step1) === "function"){
 checkout_step1();
  }else{
 t_chkout_S1_call=true; 
  }
  if(typeof(checkout_step2)!=="undefined" && typeof(checkout_step2) === "function"){
 checkout_step2();
  }else{
 t_chkout_S2_call=true;
  }
  ';
   } else {
  $step2_onFocus = '
 if(typeof(checkout_events)!=="undefined" && typeof(checkout_events) === "function"){
 checkout_events();
  }else{
 t_chkout_steps_event=true;
  }

  
  ';
   }
   //check woocommerce version and add code
   $this->wc_version_compare($step2_onFocus);
}

/**
* Enhanced E-commerce tracking checkout step 3
*
* @access public
* @return void
*/
public function checkout_step_3_tracking()
{
   if ($this->disable_tracking($this->ga_eeT)) {
  return;
   }
   $code_step_3 = '
   if(typeof(checkout_step3)!=="undefined" && typeof(checkout_step3) === "function"){
 checkout_step3();
  }else{
 t_chkout_S3_call=true;
  }
   ';
   $inline_js = $code_step_3;
   //check woocommerce version and add code
   $this->wc_version_compare($inline_js);
}

/**
* Google Analytics content grouping
* Pages: Home, Category, Product, Cart, Checkout, Search ,Shop, Thankyou and Others
*
* @access public
* @return void
*/
function add_page_type()
{
   //identify pages
   if (is_home() || is_front_page()) {
  $t_page_name = "Home Page";
   } else if (is_product_category()) {
  $t_page_name = "Category Pages";
   } else if (is_product()) {
  $t_page_name = "Product Pages";
   } else if (is_cart()) {
  $t_page_name = "Cart Page";
   } else if (is_order_received_page()) {
  $t_page_name = "Thankyou Page";
   } else if (is_checkout()) {
  $t_page_name = "Checkout Page";
   } else if (is_search()) {
  $t_page_name = "Search Page";
   } else if (is_shop()) {
  $t_page_name = "Shop Page";
   } else if (is_404()) {
  $t_page_name = "404 Error Pages";
   } else {
  $t_page_name = "Others";
   }
   //set js parameter - page name
   //$this->wc_version_compare("tvc_pt=" . json_encode($t_page_name) . ";");
   return $t_page_name;

   //add content grouping code

}
/**
* woocommerce version compare
*
* @access public
* @return void
*/
public function wc_version_compare($codeSnippet)
{
   global $woocommerce;
   if (version_compare($woocommerce->version, "2.1", ">=")) {
  wc_enqueue_js($codeSnippet);
   } else {
  $woocommerce->add_inline_js($codeSnippet);
   }
}

/**
* Check if tracking is disabled
*
* @access private
* @param mixed $type
* @return bool
*/
private function disable_tracking($type)
{
   if (is_admin() || current_user_can("manage_options") || (!$this->ga_id) || "no" == $type) {
  return true;
   }
}

/**
* Get oredered Items for check out page.
*
* @access public
* @return void
*/
public function get_ordered_items()
{
   global $woocommerce;
   $chkout_id_json = array();
   //get all items added into the cart
   $i = 0;
   foreach ($woocommerce->cart->cart_contents as $item) {
  $p = wc_get_product($item["product_id"]);

  $category = get_the_terms($item["product_id"], "product_cat");
  $categories = "";
  if ($category) {
 foreach ($category as $term) {
$categories .= $term->name . ",";
 }
  }
  //remove last comma(,) if multiple categories are there
  $categories = rtrim($categories, ",");

  //for variable product
  if ($p->is_type('variable') && $p->has_child()) {
 $t_var_metadata = wc_get_product($item["variation_id"]);
 $t_var_sku = $t_var_metadata->get_sku();
 $t_var_prc = $t_var_metadata->get_sale_price() ? $t_var_metadata->get_sale_price() : $t_var_metadata->get_regular_price(); //get price
 $t_var_sprc = $t_var_metadata->get_sale_price(); //get sale price
 $t_var_rprc = $t_var_metadata->get_regular_price(); //get regular price
 //get var product weight
 $t_var_wt = '';
 if ($t_var_metadata->get_weight() == "") {
$t_var_wt = $t_var_metadata->get_weight() . ' ' . esc_attr(get_option('woocommerce_weight_unit')); //cond. here bcoz of weight unit
 }
 if (version_compare($woocommerce->version, "2.7", "<")) {
$chkout_json[$i] = array(
"tvc_id" => esc_html($p->id),
"tvc_i" => esc_html($p->id),
"tvc_n" => esc_html($p->get_title()),
"tvc_p" => esc_html($t_var_prc),
"tvc_c" => esc_html($categories),
"tvc_q" => esc_js($item["quantity"]),
"tvc_sp" => $t_var_sprc, //get sale price
"tvc_rp" => $t_var_rprc, //get regular price
"tvc_pd" => $this->cal_prod_discount($t_var_rprc, $t_var_sprc),
"tvc_vat" => $t_var_metadata->get_variation_attributes(), //get avialable attr
"tvc_wt" => $t_var_wt,
"tvc_di" => $t_var_metadata->get_dimensions(), //dimensions
"tvc_ss" => $t_var_metadata->is_in_stock(),
"tvc_st" => $t_var_metadata->get_stock_quantity(),
"tvc_tst" => $t_var_metadata->get_total_stock(),
);
 } else {
$chkout_json[$i] = array(
"tvc_id" => esc_html($p->get_id()),
"tvc_i" => esc_html($p->get_id()),
"tvc_n" => esc_html($p->get_title()),
"tvc_p" => esc_html($t_var_prc),
"tvc_c" => esc_html($categories),
"tvc_q" => esc_js($item["quantity"]),
"tvc_sp" => $t_var_sprc, //get sale price
"tvc_rp" => $t_var_rprc, //get regular price
"tvc_pd" => $this->cal_prod_discount($t_var_rprc, $t_var_sprc),
"tvc_vat" => $t_var_metadata->get_variation_attributes(), //get avialable attr
"tvc_wt" => $t_var_wt,
//"tvc_di" => $t_var_metadata->get_dimensions(), //dimensions
"tvc_ss" => $t_var_metadata->is_in_stock(),
"tvc_st" => $t_var_metadata->get_stock_quantity(),
"tvc_tst" => $t_var_metadata->get_stock_quantity(),
);
 }

  } else if ($p->is_type('simple')) {
 //get product weight
 $t_wt = '';
 if ($p->has_weight()) {
$t_wt = $p->get_weight() . ' ' . esc_attr(get_option('woocommerce_weight_unit')); //cond. here bcoz of weight unit
 }
 if (version_compare($woocommerce->version, "2.7", "<")) {
$chkout_json[$i] = array(
"tvc_i" => esc_js($p->get_sku() ? $p->get_sku() : $p->id),
"tvc_n" => esc_js($p->get_title()),
"tvc_p" => esc_js($p->sale_price ? $p->sale_price : $p->get_price()),
"tvc_c" => $categories,
"tvc_q" => esc_js($item["quantity"]),
"tvc_isf" => $p->is_featured(),
"tvc_wt" => $t_wt, //weight
"tvc_di" => $p->get_dimensions(), //dimensions
"tvc_ss" => $p->is_in_stock(),
"tvc_pd" => $this->cal_prod_discount($p->regular_price, $p->sale_price),
"tvc_st" => $p->get_stock_quantity(),
"tvc_tst" => $p->get_total_stock(),
"tvc_rc" => $p->get_rating_count(),
"tvc_rs" => $p->get_average_rating()
);
 } else {
$chkout_json[$i] = array(
"tvc_i" => esc_js($p->get_sku() ? $p->get_sku() : $p->get_id()),
"tvc_n" => esc_js($p->get_title()),
"tvc_p" => esc_js($p->get_sale_price() ? $p->get_sale_price() : $p->get_regular_price()),
"tvc_c" => $categories,
"tvc_q" => esc_js($item["quantity"]),
"tvc_isf" => $p->is_featured(),
"tvc_wt" => $t_wt, //weight
//"tvc_di" => $p->get_dimensions(), //dimensions
"tvc_ss" => $p->is_in_stock(),
"tvc_pd" => $this->cal_prod_discount($p->get_regular_price(), $p->get_sale_price()),
"tvc_st" => $p->get_stock_quantity(),
"tvc_tst" => $p->get_stock_quantity(),
"tvc_rc" => $p->get_rating_count(),
"tvc_rs" => $p->get_average_rating()
);
 }

  }
  if ($this->fb_pixel && $this->fb_pixel_data) {
 array_push($chkout_id_json,$chkout_json[$i]['tvc_i']);
  }
  $i++;

   }
   if ($this->fb_pixel && $this->fb_pixel_data) {
  $tvc_content_ids = implode(",",  $chkout_id_json);
  $total = WC()->cart->total;
  $total = preg_replace('/[^\d,\.]/', '', $total);
  $total = preg_replace('/,(\d{2})$/', '.$1', $total);
  $tvc_qty = $woocommerce->cart->get_cart_contents_count();
  echo "<script>
 var tvc_content_ids_js = '".$tvc_content_ids."';
 fbq('track', 'InitiateCheckout',{ 
'currency':'" . $this->ga_LC . "',
'content_type':'product',
'content_ids':tvc_content_ids_js.split(','),
'value': '" . $total . "',
'num_items': '".$tvc_qty."'
 });
  </script>";
   }

   //make product data json on check out page
   $this->wc_version_compare("tvc_ch=" . json_encode($chkout_json) . ";");
}

/**
* 404 Error Tracking
* 
*/
public function error_404_tracking()
{
   if (is_404() && $this->ga_404ET) {
  $error_call = '
  if(typeof(error_404_tracking)!=="undefined" && typeof(error_404_tracking) === "function"){
 error_404_tracking();
  }else{
  t_404_error_call=true;
  }
  ';
  $this->wc_version_compare($error_call);
   }
}

/**
* Adding internal promotion code
*
* @access public
* @return void
*/
function internal_promotion()
{
   //check if option is enabled by user or not
   if (!$this->ga_InPromo)
  return;
   //get user defined internal promotion data
   $t_internal_promo_data = $this->ga_InPromoData;
   if (!empty($t_internal_promo_data)) {
  $t_internal_promo_data_pipe = explode("\r\n", $t_internal_promo_data);
  $t_internal_promo_data = array();

  for ($i = 0; $i < sizeof($t_internal_promo_data_pipe); $i++) {
 $temp_Arr = explode(',', $t_internal_promo_data_pipe[$i]);
 $t_internal_promo_data_temp = array($temp_Arr[0] => array(
"tvc_i" => $temp_Arr[1],
"tvc_n" => $temp_Arr[2],
"tvc_c" => $temp_Arr[3],
"tvc_po" => $temp_Arr[4]
 ));
 array_push($t_internal_promo_data, $t_internal_promo_data_temp);
  }
  if (empty($t_internal_promo_data)) {
 $t_internal_promo_data = array();
  }
			//convert array into json and add into footer
  $this->wc_version_compare("tvc_ip=" . json_encode($t_internal_promo_data) . ";");
  $internal_promo_js = '
				if(typeof(t_internal_promotion)!=="undefined" && typeof(t_internal_promotion) === "function"){
										t_internal_promotion();
									}else{
										t_inter_call=true;
									}
			';

  $this->wc_version_compare($internal_promo_js);
   }
}

/**
* Calculate Product discount
*
* @access private
* @param mixed $type
* @return bool
*/
private function cal_prod_discount($t_rprc, $t_sprc)
{  //older $product Object
   $t_dis = '0';
   //calculate discount
   if (!empty($t_rprc) && !empty($t_sprc)) {
  $t_dis = sprintf("%.2f", (($t_rprc - $t_sprc) / $t_rprc) * 100);
   }
   return $t_dis;
}

/**
* Form Field Analysis in footer
*
* @access public
* @return void
*/
function form_field_tracking()
{
   $form_field_js = '
  if(typeof(form_field_tracking)!=="undefined" && typeof(form_field_tracking) === "function"){
 form_field_tracking();
  }else{
 t_form_call=true;
  }
   ';
   //check if option is enabled by user or not
   if ($this->ga_FF)
  $this->wc_version_compare($form_field_js);
}

/**
* Conversion tracking code
*
* @access public
* @return void
*/
public function fb_tracking_code()
{
   if ($this->fb_pixel && $this->fb_pixel_data) {
  echo "<script>
!function(f,b,e,v,n,t,s)
{if(f.fbq)return;n=f.fbq=function(){n.callMethod?
n.callMethod.apply(n,arguments):n.queue.push(arguments)};
if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
n.queue=[];t=b.createElement(e);t.async=!0;
t.src=v;s=b.getElementsByTagName(e)[0];
s.parentNode.insertBefore(t,s)}(window, document,'script',
'https://connect.facebook.net/en_US/fbevents.js');
fbq('init', " . $this->fb_pixel_data . ");
fbq('track','PageView');
" . $this->track . "
   </script>
 <noscript><img height='1' width='1' style='display:none'
src='https://www.facebook.com/tr?id=" . $this->fb_pixel_data . "&ev=PageView&noscript=1'
   /></noscript>";
   }

}
public function add_google_fb_conversion_tracking()
{
   if (is_order_received_page()) {
  $order_id = empty($_GET["order"]) ? ($GLOBALS["wp"]->query_vars["order-received"] ? $GLOBALS["wp"]->query_vars["order-received"] : 0) : absint($_GET["order"]);
  $order = new WC_Order($order_id);
  if ($this->ga_adwords && $this->ga_adwords_data && $this->ga_adwords_label) {
 echo '<script type="text/javascript">
   /* <![CDATA[ */
   var google_conversion_id = ' . $this->ga_adwords_data . ';
   var google_conversion_label = "' . $this->ga_adwords_label . '";
   var google_conversion_value = ' . $order->get_total() . ';
   var google_conversion_currency ="' . $this->ga_LC . '";
var google_remarketing_only = false;
/* ]]> */ 
   </script>
   <script type="text/javascript"
   src="//www.googleadservices.com/pagead/conversion.js">
   </script>
   <noscript>
  <div style="display:inline;">
   <img height="1" width="1" style="border-style:none;" alt=""
   src="//www.googleadservices.com/pagead/
   conversion/' . $this->ga_adwords_data . '/?value=' . $order->get_total() . '&amp;currency_code="' . $this->ga_LC . '"
   &amp;label=' . $this->ga_adwords_label . '&amp;guid=ON&amp;script=0">
</div>
   </noscript>';
  }

   }
}
}
