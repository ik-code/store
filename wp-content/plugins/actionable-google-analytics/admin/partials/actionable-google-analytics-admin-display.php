<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       tatvic.com
 * @since      1.0.0
 *
 * @package    Actionable_Google_Analytics
 * @subpackage Actionable_Google_Analytics/admin/partials
 *
 */
if (!defined('ABSPATH')) {
    exit;
}

	$site_url = "admin.php?page=actionable-google-analytics-admin-display&tab=";
	
	if(isset($_GET['tab']) && $_GET['tab'] == 'general_settings'){
		$general_class_active = "active";
	}
	else{
		$general_class_active = "";
	}
	if(isset($_GET['tab']) && $_GET['tab'] == 'conversion_tracking'){
		$conversion_class_active = "nav-link active";
	}
	else{
		$conversion_class_active = "";
	}
	if(isset($_GET['tab']) && $_GET['tab'] == 'google_optimize'){
		$optimize_class_active = "active";
	}
	else{
		$optimize_class_active = "";
	}
	if(isset($_GET['tab']) && $_GET['tab'] == 'advanced_tracking'){
		$advanced_class_active = "active";
	}
	else{
		$advanced_class_active = "";
	}
	if(empty($_GET['tab'])){
		$general_class_active = "active";
	}
	if(isset($_GET['tab']) && $_GET['tab'] == 'datastudio_report'){
		$datastudio_active = "active";
	}
	else{
		$datastudio_active = "";
	}

	
?>
<header style="width:auto;margin-left:10px;">
	<img class ="banner" src='<?php echo plugins_url('../images/banner.png', __FILE__ )  ?>'>
</header>

		<ul class="nav nav-tabs nav-pills" style="margin-left: 10px;margin-top:20px;">
			<li class="nav-item"> 
				<a  href="<?php echo $site_url.'general_settings'; ?>"  class="border-left aga-tab nav-link <?php echo $general_class_active; ?>">General Setting</a>
			</li>
			<li class="nav-item" ><a href="<?php echo $site_url.'conversion_tracking'; ?>" class="border-left  aga-tab nav-link <?php echo $conversion_class_active; ?>">Conversion Tracking</a></li>
			<li class="nav-item"><a href="<?php echo $site_url.'google_optimize'; ?>" class="border-left aga-tab nav-link <?php echo $optimize_class_active; ?>">Google Optimize</a></li>
			<li class="nav-item"><a href="<?php echo $site_url.'advanced_tracking'; ?>" class="border-left aga-tab nav-link <?php echo $advanced_class_active; ?>">Advanced Tracking</a></li>
			<li class="nav-item"><a href="<?php echo $site_url.'datastudio_report'; ?>" class="border-left aga-tab nav-link <?php echo $datastudio_active; ?>">Add-On Services</a></li>
		</ul>
