<?php
if(isset($_POST['aga_submit_plugin'])){
    Actionable_Google_Analytics_Settings::add_update_settings('aga_advanced_tracking_settings');
}
$data = unserialize(get_option('aga_advanced_tracking_settings'));
?>

<div class="container">
	<div class="row" style="margin-left:-11%; !important;">
		<div class= "col col-9">
			<div class="card mw-100" style="padding:0;">
					<div class="card-header">
						<h5> Actionable Google Analytics</h5>
					</div>
				<div class="card-body">
					<form id="aga_plugin_form" method="post" action="" enctype="multipart/form-data" >

						<table class="table table-bordered table-md">
						<tbody>
						<tr>
							<td>
								<label class="align-middle" for= "woocommerce_actionable_google_analytics_ga_UID" >User ID Tracking</label>
							</td>
							<td>
								<label class ="align-middle " for="ga_UID">
								<?php $ga_UID = !empty($data['ga_UID']) ? 'checked' : ''; ?>
								<input class="" type="checkbox" name="ga_UID" id="ga_UID" style="" <?php echo $ga_UID; ?> > Enable User ID Tracking <i>(Optional)</i>
								</label>
								<p class="description"  style="text-align: justify;">Enable this feature to get more accurate user count &amp; better analyze the signed-in user experience.  To use User ID Tracking kindly create new <b>View in GA</b> as instructed in <b>step 1 of this</b> <a href="http://plugins.tatvic.com/enhanced-ecommerce-installation-wizard/?store_type=woocommerce#1" target="_blank"> wizard</a>.</p>
						   </td>
						 </tr>
						<tr>
							<td>
								<label class="align-middle" for= "woocommerce_actionable_google_analytics_ga_cID" >Client ID Tracking</label>
							</td>
							<td>
								<label class ="align-middle " for="ga_cID">
								<?php $ga_cID = !empty($data['ga_cID']) ? 'checked' : ''; ?>
								<input class="" type="checkbox" name="ga_cID" id="ga_cID" style="" <?php echo $ga_cID; ?> > Enable Client ID Tracking <i>(Optional)</i>
								</label>
								<p class="description"  style="text-align: justify;">Enable this feature to get more accurate user count &amp; better analyze the signed-in user experience.  To use User ID Tracking kindly create new <b>View in GA</b> as instructed in <b>step 1 of this</b> <a href="http://plugins.tatvic.com/enhanced-ecommerce-installation-wizard/?store_type=woocommerce#1" target="_blank"> wizard</a>.</p>
						   </td>
						 </tr>
						  <tr>
						   <td>
							<label class="align-middle" for= "ga_CG" >Content Grouping</label>
						   </td>
						   <td>
							<label class="align-middle" for="ga_CG">
							<?php $ga_CG = !empty($data['ga_CG']) ? 'checked' : ''; ?>
							<input type="checkbox" name="ga_CG" id="ga_CG" <?php echo $ga_CG;?> > Add Code to enable content grouping <i>(Optional)</i>
							</label>
							 <p class="description" style="text-align: justify;">Content grouping helps you group your web pages (content). To use this feature create Content Grouping in your GA as instructed in <b>step 2 of this </b><a href="http://plugins.tatvic.com/enhanced-ecommerce-installation-wizard/?store_type=woocommerce#2" target="_blank">wizard</a>.</p>
						   </td>
						  </tr>
						  <tr>
						   <td>
							<label class="align-middle" for="ga_FF">Form Field Tracking</label>
						   </td>
						   <td>
							<label class="align-middle" for="ga_FF">
								  <?php $ga_FF = !empty($data['ga_FF']) ? 'checked' : ''; ?>
							 <input class="" type="checkbox" name="ga_FF" id="ga_FF" style="" <?php echo $ga_FF;?>  > Add Code to enable Form Field Analysis <i>(Optional)</i>
							  <i style="cursor: help;" class="fas fa-question-circle" title="Enable this feature to carry out form field analysis of your E-commerce store"></i>
							</label>
						   </td>
						  </tr>
						  <tr>
						   <td>
							<label class="align-middle" for="ga_IPA">IP Anonymization</label>
						   </td>
						   <td>
							<label class="align-middle" for="ga_IPA">
						   <?php $ga_IPA = !empty($data['ga_IPA']) ? 'checked' : ''; ?>		
							<input class="" type="checkbox" name="ga_IPA" id="ga_IPA" style="" <?php echo $ga_IPA;?> > Enable IP Anonymization <i>(Optional)</i>
							<i style="cursor: help;" class="fas fa-question-circle" title="Use this feature to anonymize (or stop collecting) the I.P Address of your users in Google Analytics. Be in legal compliance by using I.P Anonymization which is important for EU countries"></i>
							</label>	
						   </td>	
						  </tr>
						   <tr>
							<td>
							 <label class="align-middle" for="ga_OPTOUT">Google Analytics Opt Out</label>
							</td>
						   <td>
							<label class="align-middle" for="ga_OPTOUT">
							 <?php $ga_OPTOUT = !empty($data['ga_OPTOUT']) ? 'checked' : ''; ?>		
							<input class="" type="checkbox" name="ga_OPTOUT" id="ga_OPTOUT" style="" <?php echo $ga_OPTOUT;?> > Enable Google Analytics Opt Out <i>(Optional)</i>
						   <i style="cursor: help;" class="fas fa-question-circle" title="Use this feature to provide website visitors the ability to prevent their data from being used by Google Analytics As per the GDPR compliance."></i>
							</label>	
						   </td>	
						  </tr>
						  <tr>
						   <td>
							<label class="align-middle" for="ga_404ET">404 Error Tracking</label>
						   </td>
						   <td>
							<label class="align-middle" for="ga_404ET">
						   <?php $ga_404ET = !empty($data['ga_404ET']) ? 'checked' : ''; ?>	
							<input class="" type="checkbox" name="ga_404ET" id="ga_404ET" style="" <?php echo $ga_404ET;?> > Enable 404 Error Tracking <i>(Optional)</i>
							<i style="cursor: help;" class="fas fa-question-circle" title="Enable this feature to fire an event whenever a user lands on your 404 Error Page. You can view this report in Behavior > Events section. (Category Name - 404_error)"></i>
							</label>
						   </td>
						  </tr>
						  <tr rowspan = "2">
						   <td>
							<label class="align-middle" for="ga_InPromo">Internal Promotion</label>
						   </td>
						   <td>
							<label class="align-middle" for="ga_InPromo">
						   <?php $ga_InPromo = !empty($data['ga_InPromo']) ? 'checked' : ''; ?>	
							<input class="" type="checkbox" name="ga_InPromo" id="ga_InPromo" style="" <?php echo $ga_InPromo;?>>  Add Internal Promotion Tracking Code <i>(Optional)</i>
						   <i style="cursor: help;" class="fas fa-question-circle" title="This feature enables internal promotion report in Enhanced Ecommerce.
					To use Internal Promotion feature, Please provide us the data in the requested format:
					Image Path, Promo ID, Name, Creative, Position of the Banner"></i>
						   
							<textarea style="margin-top:10px;margin-left:18px;" rows="3" cols="60" class="input-text wide-input " type="textarea" name="ga_InPromoData" id="ga_InPromoData" style="" placeholder="Image Path,ID,Name,Creative,Position" ><?php echo $data['ga_InPromoData'];?></textarea>
							<p class="description">Example:
						http://estore.tatvic.com/wp-content/uploads/2014/10/promo1.png,self_promo1,promotion,new_year_sale,top_banner<br><br>Where,<br>
						Image Path: http://estore.tatvic.com/wp-content/uploads/2014/10/promo1.png<br>
						Promo ID: self_promo1<br> 
						Name: promotion<br>
						Creative: new_year_sale<br>
						Position of the Banner: top_banner<br><br>
						Note: Seperate more than one internal promotion data by new line. Also, do not use white space in your name. 
						</p>
							</label>
						   </td>
						   
						  </tr>
						 </tbody>
						</table>
						<p class="submit save-for-later" id="save-for-later">
							<button type="submit" class="btn btn-primary btn-success" id="aga_submit_plugin" name="aga_submit_plugin">Submit</button>
						</p>
					</form>
				</div>
			</div>
		</div>
		<?php require_once('sidebar.php');?>
	</div>
</div>