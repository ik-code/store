<?php
	if(isset($_POST['aga_submit_plugin'])){
		Actionable_Google_Analytics_Settings::add_update_settings('aga_conversion_settings');
	}
  $data = unserialize(get_option('aga_conversion_settings'));
?>

<div class="container">
	<div class="row" style="margin-left:-11%; !important;">
		<div class= "col col-9">
			<div class="card mw-100" style="padding:0px;">
					<div class="card-header">
						<h5> Actionable Google Analytics</h5>
					</div>
				<div class="card-body">
					<form id="aga_plugin_form" method="post" action="" enctype="multipart/form-data" >
								<table class="table table-bordered table-md">
									<tbody>
										<tr>
											<td>
												<label class="align-middle" >
												<img class="gad_label" src="<?php echo plugins_url('../images/adwords.png', __FILE__ )  ?>" data-container="body" data-toggle="popover" data-placement="bottom" data-content="<a href='https://support.google.com/adwords/answer/6146252?hl=en&amp;ref_topic=3119071&amp;visit_id=1-636583363025957972-4187090916&amp;rd=1 targe=_blank'>Google AdWords</a> Reach new customers and grow your business with AdWords, Google's online advertising program. These guides are designed to get you up to speed quickly, so you can create successful ads and turn your advertising investment into revenue">
												Google Adwords
												</label>
											</td>
											<td >
												<label class ="align-middle" for="ga_adwords">
												<?php $ga_adwords = !empty($data['ga_adwords'])? 'checked' : ''; ?>
												<input type="checkbox" name="ga_adwords" id="ga_adwords" <?php echo $ga_adwords;?> > Enable Google Adwords Conversion Tracking <i>(Optional)</i></label>
												<input style="margin-top:10px;" type="text" size="30" name="ga_adwords_data" id="ga_adwords_data"   placeholder="Google Adwords Conversion ID"  value = "<?php echo $data['ga_adwords_data'];?>" >
												<i style="cursor: help;" class="fas fa-question-circle" id="ga_adwords_data" title="Enter Adwords Conversion ID without 'AW-' Prefix "></i><br/>
												<input  size="30" type="text" name="ga_adwords_label" id="ga_adwords_label" style="margin-top:10px;" value = "<?php echo $data['ga_adwords_label'];?>" placeholder="Google Adwords Conversion Label">
												<i style="cursor: help;" class="fas fa-question-circle" id="ga_adwords_label"  title="Enter a valid Google Adwords Conversion Label"></i>
											</td>
										</tr>
										<tr>
											<td>
												<label class="align-middle" >
												<img class="fb_label" src="<?php echo plugins_url('../images/facebook.jpg', __FILE__ )  ?>" data-container="body" data-toggle="popover" data-placement="bottom" data-content="<a href='https://developers.facebook.com/docs/facebook-pixel'>Facebook Pixel</a> helps you track conversions from Facebook ads, optimize ads based on collected data, build targeted audiences for future ads, and remarket to qualified leads.">
												&nbsp;Facebook Pixel
												</label>
											</td>
											<td>
												<label class="align-middle" for="fb_pixel">
													
												<?php $fb_pixel = !empty($data['fb_pixel'])? 'checked' : ''; ?>
												<input class="" type="checkbox" name="fb_pixel" id="fb_pixel" style="" <?php echo $fb_pixel;?>> Enable Facebook Pixel Tracking <i>(Optional)</i></label><br/>
												<input style="margin-top:10px;" size="30"  type="text" name="fb_pixel_data" id="fb_pixel_data" value="<?php echo $data['fb_pixel_data'];?>" placeholder="Facebook Pixel Conversion ID">
												<i  class="fas fa-question-circle fb_span" title="Enter a valid Facebook pixel ID"></i>
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