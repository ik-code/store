<?php
$email = unserialize(get_option('aga_options'))['ga_email'];
if (isset($_REQUEST["ga_email"])) {
	$update_made_for_email = $_REQUEST["ga_email"] != $email;
	if ($update_made_for_email) {
		if ($_REQUEST["ga_email"] != "") {
			$t_email = $_REQUEST["ga_email"];
			$token = $_REQUEST["ga_auth_token"];
			$purchase_code = unserialize(get_option('aga_purchase_code'));
			Actionable_Google_Analytics_Activator::send_email_to_tatvic($t_email, 'active',$token, $purchase_code['purchase_code']);
		}
	}
}
if(isset($_POST['aga_submit_plugin'])){
	Actionable_Google_Analytics_Settings::add_update_settings('aga_options');
}
$data =  unserialize(get_option('aga_options'));


?>
<div class="container">
	<div class="row" style="margin-left:-11%; !important;">
		<div class= "col col-9" >
			<div class="card mw-100" style="padding:0px;">
				<div class="card-header">
					<h5> Actionable Google Analytics</h5>
				</div>
			<div class="card-body">
			<form id="aga_plugin_form" method="post" action="" enctype="multipart/form-data" >
						<table class="table table-bordered">
							<tbody>
								<tr>
									<td>
										<label class= "align-middle"  for="Email">Email ID</label>
										
									</td>
									<td>
										<input type="email"  id="ga_email" name = "ga_email" value="<?php echo $data['ga_email'];?>" required="required">
										<i style="cursor: help;" class="fas fa-question-circle" title="Provide your work email address to receive plugin enhancement updates"></i>
									</td>
								</tr>
								<tr>
									<td>
										<label class="align-middle" for="woocommerce_actionable_google_analytics_ga_id">Google Analytics ID</label>
									</td>
									<td>
										<input type="text" id="ga_id" name = "ga_id" required = "required" value="<?php echo $data['ga_id'];?>">
										<i style="cursor: help;" class="fas fa-question-circle" title="Enter your Google Analytics ID here. You can login into your Google Analytics account to find your ID. e.g. UA-XXXXXX-XX"></i>
									</td>
								</tr>
								<tr>
									<td>
										<label class="align-middle" for="woocommerce_actionable_google_analytics_ga_eGTM">Use our Extension with your GTM</label>
									</td>
									<td>
										<?php $ga_eGTM = !empty($data['ga_eGTM'])? 'checked' : ''; ?>
										<input type="checkbox"  name="ga_eGTM" id="ga_eGTM" <?php echo $ga_eGTM; ?> ><br/>
										<p class="description">If Yes, follow the instructions mention in the <a href="http://plugins.tatvic.com/downloads/woo-plugin-GTM-steps.pdf" target="_blank">document</a> to learn how to setup your GTM with our Extension.</p>
									</td>
								</tr>
								<tr>
									<td>
										<label for="woocommerce_actionable_google_analytics_ga_auth_token">GA Authentication Token</label>
									</td>
									<td>
										<input type="text" id="ga_RTkn" class="form-control form-control-sm"  name = "ga_auth_token" value = "<?php echo $data['ga_auth_token'];?>"><br/>
										<p class="description"><a href="http://plugins.tatvic.com/tat_ga/ga_rdr_new.php" target="_blank">Click Here</a> to Authenticate your Google Analytics Account to See Product Refund Data in Your GA. At the end of the authentication, you will be given the token. Kindly copy paste the token in the field above.</p>
									</td>
								</tr>
								<tr>
									<td>
										<label class = "align-middle" for="woocommerce_actionable_google_analytics_ga_eeT">Enhanced Ecommerce Tracking Code</label>
									</td>
									<td>
										<label  class = "align-middle" for="woocommerce_actionable_google_analytics_ga_eeT">
											<?php $ga_eeT = !empty($data['ga_eeT'])? 'checked' : ''; ?>
										<input class="" type="checkbox" name="ga_eeT" id="ga_eeT"  <?php echo $ga_eeT; ?>>
										Add Enhanced Ecommerce Tracking Code
										<i style="cursor: help;" class="fas fa-question-circle" title="This feature add enhance ecommerce feature to your store"></i>
										</label>
									</td>
								</tr>
								<tr>
									<td>
										<label class = "align-middle" for="ga_PrivacyPolicy">Privacy Policy</label>
									</td>
									<td>
										<label  class = "align-middle" for="ga_PrivacyPolicy">
											<?php $ga_PrivacyPolicy = !empty($data['ga_PrivacyPolicy'])? 'checked' : ''; ?>
										<input type="checkbox" onchange="enableSubmit();" name="ga_PrivacyPolicy" id="ga_PrivacyPolicy" required="required" <?php echo $ga_PrivacyPolicy; ?>>
										Accept Privacy Policy of Plugin
										<p class="description">By using Tatvic Plugin, you agree to Tatvic plugin's <a href= "https://www.tatvic.com/privacy-policy/?ref=plugin_policy&utm_source=plugin_backend&utm_medium=woo_premium_plugin&utm_campaign=GDPR_complaince_ecomm_plugins" target="_blank">Privacy Policy</a></p>
										</label>
									</td>
								</tr>
							</tbody>
						</table>
					<p class="submit save-for-later" id="save-for-later">
						<button type="submit"  class="btn btn-primary btn-success" id="aga_submit_plugin" name="aga_submit_plugin">Submit</button>
					</p>
			</form>
			</div>
			</div>
		</div>
		<?php require_once('sidebar.php');?>
	</div>
</div>