<?php
if(isset ($_POST['aga_api_btn'])) {
	$api = new Actionable_Google_Analytics_Envato_Api();
	$api->api_validation($_POST['purchase_code']);
}
?>
<header style="width:auto;">
	<img class ="banner" src='<?php echo plugins_url('../images/banner.png', __FILE__ )  ?>' >
</header>
<form method="POST">
<div style="margin: auto; width:550px; height: 345px;background-color: #00A1B9;">
	<div style="margin-top: 80px;padding: 25px;" class="d-flex align-items-center flex-column justify-content-center h-100 text-white" id="header">
		<h2 style="font-size: 34px;">Enter Envato Purchase Code</h2>
		<div  style="margin-top: 20px;width:435px;"class="form-group input-group mb-3" >
			<input style="padding:20px;" name="purchase_code" required="required" style="margin-left: 10px;margin-right: 10px;" class="form-control form-control-lg" placeholder="Purchase Code" type="text">
		</div>
		<div style="margin-top: 20px;width:435px;" class="form-group input-group mb-3">
			<button style="padding:22px; line-height: 13px;text-align: center; background-color: #2c3e50;" class="btn btn-lg btn-block text-white" name="aga_api_btn">Verify</button>
		</div>
		<div style="margin-top: 10px;width:435px;" class="pull-left">
			<a class="text-white" target="_blank" href="https://help.market.envato.com/hc/en-us/articles/202822600-Where-Is-My-Purchase-Code">Where to find verification code?</a>
		</div>
	</div>
</div>
</form>
