<?php
	if(isset($_POST['aga_submit_plugin'])){
		Actionable_Google_Analytics_Settings::add_update_settings('aga_optimize_settings');
	}
  $data = unserialize(get_option('aga_optimize_settings'));
?>
<div class="container">
	<div class="row" style="margin-left:-11%; !important;">
		<div class= "col col-9">
			<div class="card mw-100" style="padding: 0px;">
				<div class="card-header">
					<h5> Actionable Google Analytics</h5>
				</div>
				<div class="card-body">
					<form id="aga_plugin_form" method="post" action="" enctype="multipart/form-data" >
							<table class="table table-bordered table-md">
								<tbody>
									<tr>
										<td>
											<label class=" align-middle" >
											<img class="google_optimize_label" src="<?php echo plugins_url('../images/google_optimize.png', __FILE__ )  ?>" data-container="body" data-toggle="popover" data-placement="bottom" data-content="<a href='https://support.google.com/360suite/optimize/answer/6197440?hl=en&amp;ref_topic=6314903'>Google Optimize</a> allows you to test variants of web pages and see how they perform against an objective that you specify. Optimize monitors the performance of your experiment and tells you which variant is the leader.">
											Google Optimize
											</label>
										</td>
										<td>
											<label class ="align-middle" for="ga_optimize">
											<?php $ga_optimize = !empty($data['ga_optimize'])? 'checked' : ''; ?>	
											<input type="checkbox" name="ga_optimize" id="ga_optimize" style="" <?php echo $ga_optimize; ?> > Enable Google Optimize Feature <i>(Optional)</i></label>
											<input style="margin-top:10px;" type="text" size="30" name="ga_optimize_data" id="ga_optimize_data"  value = "<?php echo $data['ga_optimize_data'];?>"  placeholder="Google Optimize ID">
											<i style="cursor: help;" class="fas fa-question-circle" id="ga_optimize_data" title="Enter a valid Google Optimize ID"></i>
											<label  style="margin-top:10px;" class ="align-middle" for="ga_hide_snippet">
											<?php $ga_hide_snippet = !empty($data['ga_hide_snippet'])? 'checked' : ''; ?>	
											<input type="checkbox" class="ga_hide_snippet" name="ga_hide_snippet" id="ga_hide_snippet" style="" <?php echo $ga_hide_snippet; ?> >Remove Page hiding snippet <i>(Not Recommended)</i></label>
											<?php $ga_optimize_delay = !empty($data['ga_optimize_delay'])? $data['ga_optimize_delay'] : 4000; ?>	
											<input  style="margin-top:10px;" size = "30" min="0" type="number"  name="ga_optimize_delay" id="ga_optimize_delay"  value = "<?php echo $ga_optimize_delay;?>"   placeholder="Google Optimize Delay"><br/>
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